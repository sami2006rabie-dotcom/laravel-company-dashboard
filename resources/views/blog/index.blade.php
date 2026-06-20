@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">📚 Blog Posts</h1>

    <div class="flex justify-between items-center mb-8">
        <div></div>
        @auth
            <a href="{{ route('blog.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">+ Create Post</a>
        @endauth
    </div>

    @forelse($posts as $post)
        <div class="bg-white rounded-lg shadow p-6 mb-6 hover:shadow-lg transition">
            <div class="flex gap-6">
                @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-32 h-32 object-cover rounded">
                @endif
                <div class="flex-1">
                    <h2 class="text-2xl font-bold mb-2">{{ $post->title }}</h2>
                    <p class="text-gray-600 text-sm mb-2">By <strong>{{ $post->user->name }}</strong> • {{ $post->published_at?->format('M d, Y') }}</p>
                    <p class="text-gray-700 mb-4">{{ $post->excerpt ?? substr(strip_tags($post->content), 0, 150) }}...</p>
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-3">
                        <span>👁️ {{ $post->views }} views</span>
                        <span>💬 {{ $post->comments->count() }} comments</span>
                    </div>
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-500 hover:underline font-semibold">Read More →</a>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <p class="text-gray-500 text-lg mb-4">No blog posts published yet</p>
            @auth
                <a href="{{ route('blog.create') }}" class="text-blue-500 hover:underline font-semibold">Be the first to create one!</a>
            @else
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline font-semibold">Login to create a post</a>
            @endauth
        </div>
    @endforelse

    <div class="mt-8">{{ $posts->links() }}</div>
</div>
@endsection