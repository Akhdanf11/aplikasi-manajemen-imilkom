@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-4xl font-bold mb-6 text-gray-900">Projects</h1>

    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @php
        // Assuming role is a single object
        $userRole = Auth::user()->role->name;
    @endphp

    @if(in_array($userRole, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum']))
    <div class="mb-4">
        <label for="department-filter" class="block text-sm font-medium text-gray-700">Filter by Department</label>
        <select id="department-filter" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="">All Departments</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
    </div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('projects.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
            Create Project
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <ul id="projects-list" class="space-y-4">
            @foreach ($projects as $project)
                <li class="bg-gray-100 p-4 rounded-lg shadow-sm hover:bg-gray-200 transition flex items-center justify-between">
                    <div>
                        <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:underline text-lg font-semibold">{{ $project->name }}</a>
                        <p class="text-gray-600 mt-2">{{ Str::limit($project->description, 100) }}</p>
                        <p class="text-sm text-gray-500 mt-1"><strong>Department:</strong> {{ $project->department->name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500 mt-1"><strong>Tasks:</strong> {{ $project->tasks->where('completed', false)->count() }} incomplete, {{ $project->tasks->where('completed', true)->count() }} complete</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('projects.edit', $project) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition">
                            Edit
                        </a>
                        <button onclick="openDeleteModal({{ $project->id }})" class="bg-red-500 text-white px-3 py-1 rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                            Delete
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 flex items-center justify-center hidden">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
    
    <!-- Modal Content -->
    <div class="relative bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
        <div class="absolute inset-0 bg-white opacity-20 rounded-lg"></div>
        <div class="relative z-10 backdrop-blur-sm bg-white bg-opacity-30 borde rounded-lg">
            <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
            <p class="text-gray-700 mb-4">Are you sure you want to delete this  <b>{{ $project->name }}</b>? This action cannot be undone.</p>
            <form id="delete-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeDeleteModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                        Cancel
                    </button>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                        Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    function openDeleteModal(projectId) {
        document.getElementById('delete-modal').classList.remove('hidden');
        document.getElementById('delete-form').action = `/projects/${projectId}`;
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const filter = document.getElementById('department-filter');
        const projectsList = document.getElementById('projects-list');

        filter.addEventListener('change', function () {
            const departmentId = filter.value;

            fetch(`{{ route('projects.index') }}?department_id=${departmentId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                projectsList.innerHTML = '';

                data.projects.forEach(project => {
                    const projectElement = document.createElement('li');
                    projectElement.className = 'bg-gray-100 p-4 rounded-lg shadow-sm hover:bg-gray-200 transition flex items-center justify-between';
                    projectElement.innerHTML = `
                        <div>
                            <a href="/projects/${project.id}" class="text-blue-600 hover:underline text-lg font-semibold">${project.name}</a>
                            <p class="text-gray-600 mt-2">${project.description.substring(0, 100)}</p>
                            <p class="text-sm text-gray-500 mt-1"><strong>Department:</strong> ${project.department ? project.department.name : 'N/A'}</p>
                            <p class="text-sm text-gray-500 mt-1"><strong>Tasks:</strong> ${project.tasks.filter(task => !task.completed).length} incomplete, ${project.tasks.filter(task => task.completed).length} complete</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="/projects/${project.id}/edit" class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition">
                                Edit
                            </a>
                            <button onclick="openDeleteModal(${project.id})" class="bg-red-500 text-white px-3 py-1 rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                                Delete
                            </button>
                        </div>
                    `;
                    projectsList.appendChild(projectElement);
                });
            })
            .catch(error => console.error('Error fetching projects:', error));
        });
    });
</script>
@endsection
