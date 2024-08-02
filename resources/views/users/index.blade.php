{{-- resources/views/users/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-4xl font-bold mb-6 text-gray-900">Users</h1>

    @can('create', App\Models\User::class)
        <a href="{{ route('users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
            Add New User
        </a>
    @endcan

    <div class="mt-6 mb-8">
        <!-- Filters for roles and departments -->
        <form method="GET" action="{{ route('users.index') }}" class="flex flex-wrap gap-4 items-center mb-4">
            <div class="flex items-center">
                <label for="role" class="mr-2 text-sm font-medium text-gray-700">Role:</label>
                <select name="role" id="role" class="block w-60 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center">
                <label for="department" class="mr-2 text-sm font-medium text-gray-700">Department:</label>
                <select name="department" id="department" class="block w-60 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">All Departments</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                Filter
            </button>
        </form>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
        <!-- BPH Section -->
        <div class="bg-gray-100 p-4">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">BPH Members</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                    @if(in_array($user->role->name, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum']))
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->role ? $user->role->name : 'No Role Assigned' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->department ? $user->department->name : 'No Department Assigned' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @can('update', $user)
                                    <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                @endcan
                                @can('delete', $user)
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Non-BPH Section -->
        <div class="p-4">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Other Members</h2>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                    @if(!in_array($user->role->name, ['Ketua Umum', 'Sekretaris Umum', 'Bendahara Umum']))
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->role ? $user->role->name : 'No Role Assigned' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->department ? $user->department->name : 'No Department Assigned' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @can('update', $user)
                                    <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                @endcan
                                @can('delete', $user)
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection
