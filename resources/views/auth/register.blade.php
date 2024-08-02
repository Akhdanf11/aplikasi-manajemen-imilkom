{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-6 bg-white bg-opacity-60 rounded-lg shadow-lg backdrop-blur-md border border-gray-300">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Register') }}</h2>
            <p class="text-gray-600">{{ __('Create a new account') }}</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                <input id="name" type="text" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                <input id="password" type="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password-confirm" class="block text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="mb-4">
                <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Role') }}</label>
                <select id="role" name="role" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('role') border-red-500 @enderror" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div id="department-field" class="mb-4 hidden">
                <label for="department" class="block text-sm font-medium text-gray-700">{{ __('Department') }}</label>
                <select id="department" name="department" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('department') border-red-500 @enderror">
                    <option value="" disabled selected>{{ __('Select Department') }}</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
                @error('department')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>



            <div class="flex items-center justify-center mt-6">
                <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role');
    const departmentField = document.getElementById('department-field');

    roleSelect.addEventListener('change', function () {
        const selectedRole = roleSelect.options[roleSelect.selectedIndex].text;
        console.log('Selected Role:', selectedRole); // Debugging line

        if (selectedRole === 'Anggota Departemen' || selectedRole === 'Kepala Departemen' || selectedRole === 'Sekretaris Departemen') {
            departmentField.classList.remove('hidden');
        } else {
            departmentField.classList.add('hidden');
        }
    });

    // Trigger change event on page load to handle pre-selected role
    roleSelect.dispatchEvent(new Event('change'));
});


</script>
@endsection

