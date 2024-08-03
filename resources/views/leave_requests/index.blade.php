@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-extrabold mb-6">Permintaan Cuti</h1>

    @if (auth()->user()->role->name === 'Ketua Umum' || auth()->user()->role->name === 'Sekretaris Umum' || auth()->user()->role->name === 'Bendahara Umum')
    <a href="{{ route('leave_requests.create') }}" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow-md">
        Ajukan Cuti
    </a>
    @endif

    <!-- Filter Form -->
    <div class="mt-6 mb-4">
        <form action="{{ route('leave_requests.index') }}" method="GET" class="flex items-center space-x-4">
            <label for="department" class="text-gray-700 font-semibold">Filter berdasarkan Departemen:</label>
            <select name="department" id="department" class="form-select block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                <option value="">Semua Departemen</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept }}" {{ request('department') === $dept ? 'selected' : '' }}>
                        {{ $dept }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md">
                Filter
            </button>
        </form>
    </div>

    <!-- Leave Requests Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 bg-white shadow-md rounded-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3 px-6 text-left text-gray-500">Nama</th>
                    <th class="py-3 px-6 text-left text-gray-500">Departemen</th>
                    <th class="py-3 px-6 text-left text-gray-500">Tanggal Mulai</th>
                    <th class="py-3 px-6 text-left text-gray-500">Tanggal Selesai</th>
                    <th class="py-3 px-6 text-left text-gray-500">Alasan</th>
                    <th class="py-3 px-6 text-left text-gray-500">Status</th>
                    @if (auth()->user()->role->name === 'Ketua Umum' || auth()->user()->role->name === 'Sekretaris Umum' || auth()->user()->role->name === 'Bendahara Umum')
                        <th class="py-3 px-6 text-left text-gray-500">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($leaveRequests as $leaveRequest)
                <tr>
                    <td class="py-4 px-6">{{ $leaveRequest->user->name }}</td>
                    <td class="py-4 px-6">
                        @if ($leaveRequest->user->role)
                            {{ $leaveRequest->user->role->name }}
                        @else
                            <span class="text-gray-500">No Role Assigned</span>
                        @endif
                    </td>
                    <td class="py-4 px-6">{{ $leaveRequest->start_date }}</td>
                    <td class="py-4 px-6">{{ $leaveRequest->end_date }}</td>
                    <td class="py-4 px-6">{{ $leaveRequest->reason }}</td>
                    <td class="py-4 px-6">
                        <span class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-full {{ $leaveRequest->status === 'approved' ? 'bg-green-100 text-green-800' : ($leaveRequest->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($leaveRequest->status) }}
                        </span>
                    </td>
                    @if (auth()->user()->role->name === 'Ketua Umum' || auth()->user()->role->name === 'Sekretaris Umum' || auth()->user()->role->name === 'Bendahara Umum')
                    <td class="py-4 px-6 flex space-x-2">
                        @if ($leaveRequest->status === 'pending')
                        <form action="{{ route('leave_requests.approve', $leaveRequest->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md shadow-md">
                                Approve
                            </button>
                        </form>
                        <form action="{{ route('leave_requests.reject', $leaveRequest->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-md shadow-md">
                                Reject
                            </button>
                        </form>
                        @endif
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $leaveRequests->appends(request()->query())->links() }}
    </div>
</div>
@endsection
