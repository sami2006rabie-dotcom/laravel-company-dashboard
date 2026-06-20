@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Create New Blog Post</h1>

        <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Title</label>
                <input type="text" name="title" required class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror" value="{{ old('title') }}" placeholder="Post Title">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Content</label>
                <textarea name="content" required rows="10" class="w-full border rounded px-3 py-2 @error('content') border-red-500 @enderror" placeholder="Write your post content here...">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Excerpt</label>
                <textarea name="excerpt" rows="3" class="w-full border rounded px-3 py-2" placeholder="Brief excerpt (optional)">{{ old('excerpt') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Featured Image</label>
                <input type="file" name="featured_image" accept="image/*" class="w-full @error('featured_image') border-red-500 @enderror">
                @error('featured_image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between">
                <a href="{{ route('blog.index') }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Create Post</button>
            </div>
        </form>
    </div>
</div>
@endsection