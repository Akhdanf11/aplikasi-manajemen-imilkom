@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-4">
        <a href="{{ route('projects.index', $project) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
            &larr; Back
        </a>
    </div>
    <h1 class="text-4xl font-bold mb-6 text-gray-900">Edit Project</h1>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Project Details</h2>
        <p class="text-gray-700 mb-2"><strong>Department:</strong> {{ $project->department->name ?? 'N/A' }}</p>
        <p class="text-gray-700 mb-2"><strong>Created by:</strong> {{ $project->creator->name }}</p>
    </div>

    <form action="{{ route('projects.update', $project->id) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Project Name</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('name', $project->name) }}" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $project->description) }}</textarea>
        </div>

        <div class="flex justify-end space-x-2">
        <a href="{{ route('projects.show', $project) }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md shadow-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                    Back
                </a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                Update Project
            </button>
        </div>
    </form>
</div>
@endsection
