<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\LeaveRequestNotification;

class LeaveRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $userRole = Auth::user()->role->name ?? '';
            if (!in_array($userRole, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum'])) {
                return redirect('/')->with('error', 'Unauthorized access');
            }
            return $next($request);
        })->only('index');
    }

    public function index(Request $request)
    {
        // Filtering and pagination
        $department = $request->input('department');
        
        $leaveRequests = LeaveRequest::with('user')
            ->when($department, function ($query, $department) {
                return $query->whereHas('user', function ($query) use ($department) {
                    $query->whereHas('role', function ($query) use ($department) {
                        $query->where('name', $department);
                    });
                });
            })
            ->paginate(10);

        $departments = User::distinct('role_id')->get()->map(function ($user) {
            return $user->role->name;
        })->unique();

        return view('leave_requests.index', compact('leaveRequests', 'departments'));
    }

    public function create()
    {
        return view('leave_requests.create');
    }

    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ]);

        // Create a new leave request
        $leaveRequest = LeaveRequest::create([
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'Pending',
        ]);

        // Fetch managers to notify (adjusted to your roles)
        $managers = User::whereHas('role', function ($query) {
            $query->whereIn('name', ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum']);
        })->get();

        // Send notifications to managers
        Notification::send($managers, new LeaveRequestNotification($leaveRequest));

        // Redirect back with success message
        return redirect()->route('leave_requests.index')->with('success', 'Leave request submitted successfully.');
    }

    public function approve($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update(['status' => 'approved']);

        return redirect()->route('leave_requests.index')->with('success', 'Leave request approved.');
    }

    public function reject($id)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update(['status' => 'rejected']);

        return redirect()->route('leave_requests.index')->with('success', 'Leave request rejected.');
    }
}
