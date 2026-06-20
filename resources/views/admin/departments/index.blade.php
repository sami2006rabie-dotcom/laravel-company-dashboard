@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Manage Departments</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.departments.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-6 inline-block">+ Add Department</a>

        <div class="grid grid-cols-1 gap-4">
            @forelse($departments as $dept)
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold">{{ $dept->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $dept->description }}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.departments.edit', $dept) }}" class="text-blue-500 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.departments.destroy', $dept) }}" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Delete this department?')">Delete</button>
                            </form>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600">
                        <p>Head: {{ $dept->head_name ?? 'N/A' }}</p>
                        <p>Location: {{ $dept->location ?? 'N/A' }}</p>
                        <p>Employees: {{ $dept->users_count ?? 0 }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">No departments found</p>
            @endforelse
        </div>

        <div class="mt-8">{{ $departments->links() }}</div>
    </div>
</div>
@endsection