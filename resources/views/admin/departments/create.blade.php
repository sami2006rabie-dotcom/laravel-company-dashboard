@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Create Department</h1>

        <form action="{{ route('admin.departments.store') }}" method="POST" class="bg-white rounded-lg shadow p-6">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Department Name</label>
                <input type="text" name="name" required class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" value="{{ old('name') }}" placeholder="e.g. Information Technology">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full border rounded px-3 py-2" placeholder="Department description">{{ old('description') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Head Name</label>
                <input type="text" name="head_name" class="w-full border rounded px-3 py-2" value="{{ old('head_name') }}" placeholder="Department head name">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Location</label>
                <input type="text" name="location" class="w-full border rounded px-3 py-2" value="{{ old('location') }}" placeholder="e.g. Building A, Floor 3">
            </div>

            <div class="flex justify-between">
                <a href="{{ route('admin.departments.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Create Department</button>
            </div>
        </form>
    </div>
</div>
@endsection