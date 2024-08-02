@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('projects.index', $project) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
            &larr; Back
        </a>
    </div>

    <h1 class="text-4xl font-bold mb-6 text-gray-900">{{ $project->name }}</h1>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Project Details</h2>
        <p class="text-gray-700 mb-2"><strong>Description:</strong> {{ $project->description }}</p>
        <p class="text-gray-700 mb-2"><strong>Department:</strong> {{ $project->department->name ?? 'N/A' }}</p>
        <p class="text-gray-700 mb-2"><strong>Created by:</strong> {{ $project->creator->name }}</p>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Tasks</h2>
        <ul class="space-y-4">
            @foreach($project->tasks as $task)
                <li class="bg-gray-100 p-4 rounded-lg shadow-sm hover:bg-gray-200 transition flex items-center justify-between">
                    <div>
                        <p class="text-lg font-semibold">{{ $task->name }}</p>
                        <p class="text-gray-600">{{ $task->description }}</p>
                        <p class="text-sm text-gray-500 mt-1"><strong>Deadline:</strong> {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</p>
                        <p class="text-sm text-gray-500 mt-1"><strong>Status:</strong> {{ $task->completed ? 'Completed' : 'Incomplete' }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('tasks.edit', [$project, $task]) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition">
                            Edit
                        </a>
                        <button onclick="openDeleteModal('{{ route('tasks.destroy', [$project, $task]) }}')" class="bg-red-500 text-white px-3 py-1 rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                            Delete
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="flex justify-end mt-4">
            <a href="{{ route('tasks.create', $project) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                Add Task
            </a>
        </div>
    </div>

    <!-- Expenditures and Income sections go here -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Expenditures</h2>
        <ul class="space-y-4">
        @foreach($project->expenditures as $expenditure)
    <li class="bg-gray-100 p-4 rounded-lg shadow-sm hover:bg-gray-200 transition flex items-center justify-between">
        <div>
        @php
            // Determine the card color based on the status
            $statusClass = '';
            $statusText = ucfirst($expenditure->status); // Capitalize the first letter

            switch($expenditure->status) {
                case 'pending':
                    $statusClass = 'bg-yellow-100 text-yellow-800'; // Light yellow background and dark yellow text
                    break;
                case 'approved':
                    $statusClass = 'bg-teal-100 text-teal-800'; // Light teal background and dark teal text
                    break;
                case 'rejected':
                    $statusClass = 'bg-red-100 text-red-800'; // Light red background and dark red text
                    break;
                default:
                    $statusClass = 'bg-gray-100 text-gray-800'; // Default gray for unknown status
                    break;
            }
        @endphp
            <p class="text-lg font-semibold">{{ $expenditure->item }}</p>
            <p class="text-gray-600">{{ number_format($expenditure->amount, 2) }}</p>
            @if($expenditure->proof_image)
                <p class="text-sm text-gray-500 mt-1"><strong>Proof:</strong> <a href="{{ asset('storage/' . $expenditure->proof_image) }}" target="_blank" class="text-blue-600 hover:underline">View Image</a></p>
            @endif
        </div>
        <div class="flex space-x-2">
        @php
            // Assuming role is a single object
            $userRole = Auth::user()->role->name;
        @endphp

        @if(in_array($userRole, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum']))
            <form action="{{ route('projects.expenditures.update', [$project, $expenditure]) }}" method="POST">
                @csrf
                @method('PUT')
                <select name="status" class="bg-gray-200 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="pending" {{ $expenditure->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $expenditure->status == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $expenditure->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
                <button type="submit" class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition">
                    Update Status
                </button>
            </form>
        @else
            <div class="p-4 mb-4 border rounded-lg shadow-sm {{ $statusClass }}">
                <p class="text-sm font-semibold"><strong>Status:</strong> {{ $statusText }}</p>
            </div>
        @endif
        </div>
    </li>
@endforeach

        </ul>
        <div class="flex justify-end mt-4">
            <a href="{{ route('projects.expenditures.create', $project) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                Add Expenditure
            </a>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Income</h2>
        <ul class="space-y-4">
            @foreach($project->income as $income)
                <li class="bg-gray-100 p-4 rounded-lg shadow-sm hover:bg-gray-200 transition flex items-center justify-between">
                    <div>
                        <p class="text-lg font-semibold">{{ number_format($income->amount, 2) }}</p>
                    </div>
                    <form action="{{ route('projects.income.destroy', [$project, $income]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                            Delete
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
        <div class="flex justify-end mt-4">
            <a href="{{ route('projects.income.create', $project) }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                Add Income
            </a>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center hidden">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
    
    <!-- Modal Content -->
    <div class="relative bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
        <div class="absolute inset-0 bg-white opacity-20 rounded-lg"></div>
        <div class="relative z-10 backdrop-blur-sm bg-white bg-opacity-30 borde rounded-lg">
            <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
            <p class="mb-4">Are you sure you want to delete this item?</p>
            <form id="deleteForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-between">
                    <button type="button" onclick="closeDeleteModal()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
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
function openDeleteModal(url) {
    document.getElementById('deleteForm').action = url;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection
