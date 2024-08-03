<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Http\Requests\AttendanceRequest;
use App\Models\Project;
use App\Models\User;

class AttendanceController extends Controller
{
    /**
     * Handle clock-in request.
     *
     * @param  \App\Http\Requests\AttendanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function clockIn(AttendanceRequest $request)
    {
        // Check if there is already a clock-in record for the user today
        $existingAttendance = Attendance::where('user_id', Auth::id())
            ->whereDate('clock_in', now()->toDateString())
            ->whereNull('clock_out')
            ->first();

        if ($existingAttendance) {
            return redirect()->route('attendance.schedule')->with('error', 'You are already clocked in.');
        }

        // Create a new clock-in record
        Attendance::create([
            'user_id' => Auth::id(),
            'clock_in' => now(),
            'location' => $request->location,
            'project_id' => $request->project_id,
        ]);

        return redirect()->route('attendance.schedule')->with('success', 'Clocked in successfully.');
    }

    /**
     * Handle clock-out request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clockOut(Request $request)
    {
        $attendance = Attendance::where('user_id', Auth::id())
            ->whereNull('clock_out')
            ->first();

        if (!$attendance) {
            return redirect()->route('attendance.schedule')->with('error', 'You are not clocked in.');
        }

        // Update the clock-out time
        $attendance->update([
            'clock_out' => now(),
        ]);

        return redirect()->route('attendance.schedule')->with('success', 'Clocked out successfully.');
    }

    /**
     * Generate attendance report based on date range.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $query = Attendance::query();

        if ($request->filled('start_date')) {
            $query->whereDate('clock_in_time', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('clock_in_time', '<=', $request->end_date);
        }
        
        if ($request->filled('project_id')) {
            $query->where('project_id', $request->project_id);
        }
        
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $attendances = $query->get();
        $projects = Project::all();
        $users = User::all();

        // Prepare data for chart
        $labels = $attendances->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->clock_in_time)->format('Y-m-d'); // Group by day
        })->keys();

        $data = $attendances->groupBy(function($date) {
            return \Carbon\Carbon::parse($date->clock_in_time)->format('Y-m-d');
        })->map->count()->values();

        return view('attendance.report', compact('attendances', 'projects', 'users', 'labels', 'data'));
    }


    /**
     * Show the attendance schedule page.
     *
     * @return \Illuminate\Http\Response
     */
    public function schedule()
    {
        // Consider paginating if there is a lot of data
        $attendances = Attendance::with(['user', 'project'])->get(); // Fetch attendance data
        $projects = Project::all(); // Fetch projects
        return view('attendance.schedule', compact('attendances', 'projects'));
    }
}
