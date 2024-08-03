@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Jadwal Kehadiran</h1>
    
    <!-- Clock In Form -->
    <form action="{{ route('attendance.clockIn') }}" method="POST" id="clockIn">
        @csrf
        <input type="hidden" id="location" name="location">
        <div class="mb-4">
            <label for="project_id" class="block text-gray-700 font-medium">Pilih Proyek:</label>
            <select name="project_id" id="project_id" class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                @foreach ($projects as $project)
                <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="button" onclick="showClockInModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
            Clock In
        </button>
    </form>

    <!-- Clock Out Form -->
    <form action="{{ route('attendance.clockOut') }}" method="POST" id="clockOut" class="mt-4">
        @csrf
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg">
            Clock Out
        </button>
    </form>
    
    <!-- Attendance Calendar -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-4">Jadwal Kehadiran Bulanan</h2>
        <div class="grid grid-cols-7 gap-4">
            @foreach (range(1, 31) as $day)
                <div class="relative p-4 border rounded-lg {{ $attendances->where('day', $day)->count() ? 'bg-green-50' : 'bg-gray-50' }}">
                    <p class="text-center font-semibold text-gray-700">{{ $day }}</p>
                    @foreach ($attendances->where('day', $day) as $attendance)
                    <div class="absolute top-0 right-0 p-1 bg-green-200 text-green-800 text-xs rounded-full">
                        <span class="font-medium">In: {{ $attendance->clock_in->format('H:i') }}</span>
                        @if ($attendance->clock_out)
                            <br><span class="font-medium">Out: {{ $attendance->clock_out->format('H:i') }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Clock In Modal -->
    <div id="clockInModal" tabindex="-1" class="fixed inset-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto">
        <div class="relative max-w-lg mx-auto bg-white rounded-lg shadow-lg">
            <div class="p-6 text-center">
                <h3 class="text-lg font-medium text-gray-900">Apakah Anda yakin ingin clock in?</h3>
                <div class="flex justify-center mt-4">
                    <button type="button" onclick="submitClockIn()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg mr-2">
                        Ya, clock in
                    </button>
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-2 px-4 rounded-lg" onclick="hideClockInModal()">
                        Tidak, batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Clock Out Modal -->
    <div id="clockOutModal" tabindex="-1" class="fixed inset-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto">
        <div class="relative max-w-lg mx-auto bg-white rounded-lg shadow-lg">
            <div class="p-6 text-center">
                <h3 class="text-lg font-medium text-gray-900">Apakah Anda yakin ingin clock out?</h3>
                <div class="flex justify-center mt-4">
                    <button type="button" onclick="document.getElementById('clockOut').submit()" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg mr-2">
                        Ya, clock out
                    </button>
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-2 px-4 rounded-lg" onclick="hideClockOutModal()">
                        Tidak, batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showClockInModal() {
    document.getElementById('clockInModal').classList.remove('hidden');
}

function hideClockInModal() {
    document.getElementById('clockInModal').classList.add('hidden');
}

function showClockOutModal() {
    document.getElementById('clockOutModal').classList.remove('hidden');
}

function hideClockOutModal() {
    document.getElementById('clockOutModal').classList.add('hidden');
}

function submitClockIn() {
    getLocation();
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('location').value = position.coords.latitude + ',' + position.coords.longitude;
            document.getElementById('clockIn').submit(); // Submit the form after setting location
        }, function() {
            alert("Unable to retrieve your location.");
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}
</script>
@endsection
