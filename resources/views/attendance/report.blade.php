@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-semibold mb-6">Laporan Kehadiran</h1>
    
    <!-- Report Filter Form -->
    <form method="GET" action="{{ route('attendance.report') }}" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label for="start_date" class="block text-gray-700 font-medium">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="form-input mt-1 block w-full" value="{{ request('start_date') }}">
            </div>
            <div>
                <label for="end_date" class="block text-gray-700 font-medium">End Date:</label>
                <input type="date" id="end_date" name="end_date" class="form-input mt-1 block w-full" value="{{ request('end_date') }}">
            </div>
            <div>
                <label for="project_id" class="block text-gray-700 font-medium">Project:</label>
                <select id="project_id" name="project_id" class="form-select mt-1 block w-full">
                    <option value="">All Projects</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="user_id" class="block text-gray-700 font-medium">User:</label>
                <select id="user_id" name="user_id" class="form-select mt-1 block w-full">
                    <option value="">All Users</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
            Generate Report
        </button>
    </form>

    <!-- Attendance Table -->
    <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left border-b">User</th>
                    <th class="px-4 py-2 text-left border-b">Project</th>
                    <th class="px-4 py-2 text-left border-b">Clock In</th>
                    <th class="px-4 py-2 text-left border-b">Clock Out</th>
                    <th class="px-4 py-2 text-left border-b">Location</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $attendance->user->name }}</td>
                        <td class="px-4 py-2 border-b">{{ $attendance->project->name }}</td>
                        <td class="px-4 py-2 border-b">{{ $attendance->clock_in }}</td>
                        <td class="px-4 py-2 border-b">{{ $attendance->clock_out }}</td>
                        <td class="px-4 py-2 border-b">{{ $attendance->location }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Chart -->
    <div class="mt-8">
        <h2 class="text-2xl font-semibold mb-4">Attendance Overview</h2>
        <canvas id="attendanceChart" width="400" height="200"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Attendance',
                data: @json($data),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endsection
