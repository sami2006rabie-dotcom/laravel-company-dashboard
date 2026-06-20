<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $posts = BlogPost::where('published', true)->with('user')->orderByDesc('published_at')->paginate(10);
        return view('blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->firstOrFail();
        if (!$post->published && $post->user_id !== Auth::id()) abort(404);
        $post->increment('views');
        return view('blog.show', compact('post'));
    }

    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'featured_image' => 'nullable|image|max:2048',
            'excerpt' => 'nullable|string|max:500',
        ]);

        $validated['user_id'] = Auth::id();
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        BlogPost::create($validated);
        return redirect('/blog')->with('success', 'Post created!');
    }

    public function edit(BlogPost $post)
    {
        $this->authorize('update', $post);
        return view('blog.edit', compact('post'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $this->authorize('update', $post);
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'featured_image' => 'nullable|image|max:2048',
            'excerpt' => 'nullable|max:500',
        ]);

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) Storage::disk('public')->delete($post->featured_image);
            $validated['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        $post->update($validated);
        return redirect("/blog/{$post->slug}")->with('success', 'Updated!');
    }

    public function destroy(BlogPost $post)
    {
        $this->authorize('delete', $post);
        if ($post->featured_image) Storage::disk('public')->delete($post->featured_image);
        $post->delete();
        return redirect('/blog')->with('success', 'Deleted!');
    }
}