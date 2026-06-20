@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Total Users</h3>
            <p class="text-3xl font-bold">{{ $stats['total_users'] }}</p>
        </div>
        <div class="bg-green-500 text-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Total Departments</h3>
            <p class="text-3xl font-bold">{{ $stats['total_departments'] }}</p>
        </div>
        <div class="bg-purple-500 text-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Blog Posts</h3>
            <p class="text-3xl font-bold">{{ $stats['total_posts'] }}</p>
        </div>
        <div class="bg-orange-500 text-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold">Comments</h3>
            <p class="text-3xl font-bold">{{ $stats['total_comments'] }}</p>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold">Users Management</h2>
        </div>
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Department</th>
                    <th class="px-6 py-3 text-left">Position</th>
                    <th class="px-6 py-3 text-left">Role</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $user->name }}</td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">{{ $user->department?->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $user->position ?? 'N/A' }}</td>
                    <td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 px-3 py-1 rounded">{{ $user->role }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No users found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-6">{{ $users->links() }}</div>
    </div>

    <!-- Departments Section -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between">
            <h2 class="text-2xl font-bold">Departments</h2>
            <a href="{{ route('admin.departments.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">+ Add Department</a>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($departments as $dept)
                <div class="border border-gray-200 rounded p-4 hover:shadow-lg transition">
                    <h3 class="font-bold text-lg">{{ $dept->name }}</h3>
                    <p class="text-gray-600 text-sm mt-2">Head: {{ $dept->head_name ?? 'N/A' }}</p>
                    <p class="text-gray-600 text-sm">Location: {{ $dept->location ?? 'N/A' }}</p>
                    <p class="text-gray-600 text-sm">Description: {{ $dept->description ?? 'N/A' }}</p>
                    <p class="text-sm text-gray-500 mt-2">{{ $dept->users_count ?? 0 }} employees</p>
                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('admin.departments.edit', $dept) }}" class="text-blue-500 text-sm hover:underline">Edit</a>
                        <form method="POST" action="{{ route('admin.departments.destroy', $dept) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 text-sm hover:underline" onclick="return confirm('Delete this department?')">Delete</button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 col-span-2">No departments found</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection