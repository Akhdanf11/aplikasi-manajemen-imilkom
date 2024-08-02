<!-- resources/views/tasks/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Create Task for Project: {{ $project->name }}</h2>

        <form method="POST" action="{{ route('tasks.store', $project) }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Task Name</label>
                <input id="name" type="text" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm"></textarea>
            </div>

            <div class="mb-4">
                <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline</label>
                <input id="deadline" type="date" name="deadline" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
            </div>

            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Create Task
            </button>
        </form>
    </div>
@endsection
