@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-bold mb-4">Ajukan Cuti</h1>

    <form action="{{ route('leave_requests.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="reason" class="block text-gray-700 font-medium">Alasan:</label>
            <textarea name="reason" id="reason" class="block w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-opacity-50" rows="4">{{ old('reason') }}</textarea>
            @error('reason')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="start_date" class="block text-gray-700 font-medium">Tanggal Mulai:</label>
            <input type="date" name="start_date" id="start_date" class="block w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-opacity-50" value="{{ old('start_date') }}">
            @error('start_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="end_date" class="block text-gray-700 font-medium">Tanggal Selesai:</label>
            <input type="date" name="end_date" id="end_date" class="block w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-opacity-50" value="{{ old('end_date') }}">
            @error('end_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
            Kirim
        </button>
    </form>
</div>
@endsection
