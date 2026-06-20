@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Edit Blog Post</h1>

        <form action="{{ route('blog.update', $post) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Title</label>
                <input type="text" name="title" required class="w-full border rounded px-3 py-2" value="{{ $post->title }}">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Content</label>
                <textarea name="content" required rows="10" class="w-full border rounded px-3 py-2">{{ $post->content }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Excerpt</label>
                <textarea name="excerpt" rows="3" class="w-full border rounded px-3 py-2">{{ $post->excerpt }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Featured Image</label>
                @if($post->featured_image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Current" class="w-32 h-32 object-cover rounded">
                    </div>
                @endif
                <input type="file" name="featured_image" accept="image/*" class="w-full">
            </div>

            <div class="flex justify-between">
                <a href="{{ route('blog.show', $post->slug) }}" class="text-gray-500 hover:text-gray-700">Cancel</a>
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Update Post</button>
            </div>
        </form>
    </div>
</div>
@endsection