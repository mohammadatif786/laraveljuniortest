<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $posts = Post::with('user')->get();
        } else {
            $posts = Post::where('user_id', $user->id)->with('user')->get();
        }
        
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            abort(403, 'Admins cannot create posts.');
        }
        
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            abort(403, 'Admins cannot create posts.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();
        Post::create($validated);
        
        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        $user = Auth::user();
        
        if ($user->role === 'admin' || $post->user_id === $user->id) {
            return view('posts.show', compact('post'));
        }
        
        abort(403, 'Unauthorized action.');
    }

    public function destroy(Post $post)
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $post->delete();
            return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
        }
        
        abort(403, 'Unauthorized action.');
    }
}
