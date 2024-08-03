@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-4xl font-bold mb-6 text-gray-900">Delete Inventory</h1>

    <div class="p-4 bg-white shadow-md rounded-lg">
        <p class="text-gray-700 mb-4">Are you sure you want to delete this <b>{{ $inventory->name }}</b>? This action cannot be undone.</p>

        <form action="{{ route('inventories.destroy', $inventory->id) }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex justify-end">
                <a href="{{ route('inventories.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition mr-2">
                    Cancel
                </a>
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
