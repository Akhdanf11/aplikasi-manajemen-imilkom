<!-- resources/views/tasks/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-4xl font-bold mb-6 text-gray-900">Edit Task: {{ $task->name }}</h1>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <form action="{{ route('tasks.update', [$project, $task]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Task Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $task->name) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
                <input id="deadline" type="date" name="deadline" value="{{ old('deadline', $task->deadline ? $task->deadline->format('Y-m-d') : '') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('deadline')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="completed" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="completed" name="completed" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                    <option value="1" {{ old('completed', $task->completed) ? 'selected' : '' }}>Completed</option>
                    <option value="0" {{ !old('completed', $task->completed) ? 'selected' : '' }}>Incomplete</option>
                </select>
                @error('completed')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('projects.show', $project) }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md shadow-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                    Back
                </a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    Update Task
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
