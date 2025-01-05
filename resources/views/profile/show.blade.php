<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <!-- Profile Header -->
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">User Information</h3>
                    <a href="{{ route('profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">
                        Edit Profile
                    </a>
                </div>

                <!-- User Details -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <span class="font-medium text-gray-800 dark:text-gray-200 w-32">Name:</span>
                        <span class="text-gray-700 dark:text-gray-300">{{ $user->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <span class="font-medium text-gray-800 dark:text-gray-200 w-32">Email:</span>
                        <span class="text-gray-700 dark:text-gray-300">{{ $user->email }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
