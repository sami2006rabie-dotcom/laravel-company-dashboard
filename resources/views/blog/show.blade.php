@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        @if($post->featured_image)
            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-96 object-cover rounded-lg mb-8">
        @endif

        <article>
            <h1 class="text-4xl font-bold mb-4">{{ $post->title }}</h1>
            <div class="flex items-center gap-4 text-gray-600 mb-8 pb-6 border-b">
                <span>By <strong>{{ $post->user->name }}</strong></span>
                <span>{{ $post->published_at?->format('M d, Y') }}</span>
                <span>👁️ {{ $post->views }} views</span>
            </div>

            <div class="prose max-w-none mb-8">
                {!! nl2br(e($post->content)) !!}
            </div>

            @auth
                @if(Auth::id() === $post->user_id)
                    <div class="flex gap-2 mb-8 pb-8 border-b">
                        <a href="{{ route('blog.edit', $post) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Edit</a>
                        <form method="POST" action="{{ route('blog.destroy', $post) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="return confirm('Delete this post?')">Delete</button>
                        </form>
                    </div>
                @endif
            @endauth

            <!-- Comments Section -->
            <div class="mt-12">
                <h3 class="text-2xl font-bold mb-6">💬 Comments ({{ $post->comments()->count() }})</h3>
                
                @forelse($post->comments as $comment)
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-start mb-2">
                            <strong>{{ $comment->user->name }}</strong>
                            <span class="text-sm text-gray-500">{{ $comment->created_at->format('M d, Y') }}</span>
                        </div>
                        <p class="text-gray-700">{{ $comment->content }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">No comments yet. Be the first to comment!</p>
                @endforelse
            </div>
        </article>

        <div class="mt-8">
            <a href="{{ route('blog.index') }}" class="text-blue-500 hover:underline">← Back to Blog</a>
        </div>
    </div>
</div>
@endsection