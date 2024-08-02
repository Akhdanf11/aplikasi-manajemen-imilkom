<!-- resources/views/income/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-4">
        <a href="{{ route('projects.show', $project) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
            &larr; Back
        </a>
    </div>
    <h1 class="text-2xl font-bold mb-4 text-gray-900">Add New Income for Project: {{ $project->name }}</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('projects.income.store', $project) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                <input type="number" id="amount" name="amount" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required step="0.01">
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    Add Income
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
