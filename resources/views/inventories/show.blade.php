@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-4xl font-bold mb-6 text-gray-900">Inventory Details</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900">{{ $inventory->name }}</h2>
        <p class="text-gray-600 mt-2">{{ $inventory->description }}</p>
        <p class="text-sm text-gray-500 mt-1"><strong>Quantity:</strong> {{ $inventory->quantity }}</p>
        <p class="text-sm text-gray-500 mt-1"><strong>Department:</strong> {{ $inventory->department->name ?? 'N/A' }}</p>
        @if($inventory->image)
            <img src="{{ Storage::url($inventory->image) }}" alt="{{ $inventory->name }}" class="w-32 h-32 object-cover mt-4">
        @endif
        <div class="mt-6">
            <a href="{{ route('inventories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                Back to List
            </a>
        </div>
    </div>
</div>
@endsection
