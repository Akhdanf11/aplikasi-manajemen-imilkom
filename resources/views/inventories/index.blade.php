@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-4xl font-bold mb-6 text-gray-900">Inventories</h1>

    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @php
        $userRole = Auth::user()->role->name;
    @endphp

    @if(in_array($userRole, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum', 'Kepala Departemen', 'Sekretaris Departemen']))
    <div class="mb-6">
        <form action="{{ route('inventories.index') }}" method="GET" class="flex flex-col sm:flex-row items-center">
            <label for="department-filter" class="block text-sm font-medium text-gray-700 sm:mr-4 mb-2 sm:mb-0">Filter by Department</label>
            <select id="department-filter" name="department_id" class="mt-1 block w-full sm:w-60 px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">All Departments</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="inline-flex items-center mt-4 sm:mt-0 sm:ml-4 px-4 py-2 bg-blue-500 text-white rounded-lg shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                Filter
            </button>
        </form>
    </div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('inventories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
            Create Inventory
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($inventories as $inventory)
            <div class="bg-gray-50 shadow rounded-lg p-4">
                <a href="{{ route('inventories.show', $inventory) }}" class="text-blue-600 hover:underline text-lg font-semibold">{{ $inventory->name }}</a>
                @if($inventory->image)
                    <img src="{{ Storage::url($inventory->image) }}" alt="{{ $inventory->name }}" class="min-w-max h-32 rounded-lg mt-2 mb-2 object-cover">
                @endif
                <p class="text-gray-600">{{ Str::limit($inventory->description, 100) }}</p>
                <div class="flex items-center justify-between text-gray-500 text-sm">
                    <p><strong>Department:</strong> {{ $inventory->department->name ?? 'N/A' }}</p>
                    <p><strong>Quantity:</strong> {{ $inventory->quantity }}</p>
                </div>
                <div class="flex items-center justify-end mt-2">
                    <a href="{{ route('inventories.edit', $inventory) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition">
                        Edit
                    </a>
                    <button data-inventory-id="{{ $inventory->id }}" class="bg-red-500 text-white px-3 py-1 rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition ml-2 open-delete-modal">
                        Delete
                    </button>
                </div>
            </div>
        @empty
            <p class="text-center col-span-full text-gray-500">No inventories found.</p>
        @endforelse
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 flex items-center justify-center hidden">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-gray-900 opacity-50"></div>

    <!-- Modal Content -->
    <div class="relative bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
        <!-- Close Button -->
        <button type="button" class="absolute top-2 right-2 p-1.5 text-gray-400 hover:text-gray-900 close-modal">
            <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <span class="sr-only">Close modal</span>
        </button>

        <!-- Modal Header -->
        <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>

        <!-- Modal Body -->
        <p class="text-gray-700 mb-4">Are you sure you want to delete this <b id="inventory-name"></b>? This action cannot be undone.</p>

        <!-- Modal Footer -->
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Open modal
        document.querySelectorAll('.open-delete-modal').forEach(button => {
            button.addEventListener('click', function () {
                const inventoryId = this.getAttribute('data-inventory-id');
                const inventoryName = this.closest('div.bg-gray-50').querySelector('a').textContent;
                document.getElementById('inventory-name').textContent = inventoryName;
                document.getElementById('delete-form').action = `/inventories/${inventoryId}`;
                document.getElementById('delete-modal').classList.remove('hidden');
            });
        });

        // Close modal
        document.querySelectorAll('.close-modal').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('delete-modal').classList.add('hidden');
            });
        });
    });

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }
</script>
@endsection
