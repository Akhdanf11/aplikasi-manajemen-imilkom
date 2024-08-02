@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-4">
        <a href="{{ route('projects.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
            &larr; Back
        </a>
    </div>
    <h1 class="text-4xl font-bold mb-6 text-gray-900">Create New Project</h1>
    <div class="bg-white shadow-lg rounded-lg p-6">
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Project Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"></textarea>
            </div>
            @if(Auth::user()->role->name === 'Ketua Umum' || Auth::user()->role->name === 'Sekretaris Umum' || Auth::user()->role->name === 'Bendahara Umum')
                <div class="mb-4">
                    <label for="department_id" class="block text-sm font-medium text-gray-700">Assign Tasks To</label>
                    <select name="department_id" id="department_id" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
                        <option value="">All Departments</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                    Create Project
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
