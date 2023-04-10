<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class PostController extends Controller
{

    public function index()
    {  
        $posts = Post::orderBy('id', 'DESC')->paginate(10);  
        return view('posts.index', compact('posts'));  
    }

    public function create() 
        {  
            return view('posts.create');  
        }

        public function store(Request $request): RedirectResponse  
    {  
        $this->validate($request, [  
            'title' => 'required|string|max:151',  
            'content' => 'required',  
            'status' => 'required|integer'  
        ]);  

        $post = Post::create([  
            'title' => $request->get('title'),  
            'content' => $request->get('content'),  
            'status' => $request->get('status'),  
            'slug' => Str::slug($request->get('title'))  
        ]);  

        return redirect()->route('post.index')  
            ->with('success', 'Post created successfully.');  
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse  
    {  
        $this->validate($request, [  
            'title' => 'required|string|max:151',  
            'content' => 'required',  
            'status' => 'required|integer'  
        ]);  

        $post->update([  
            'title' => $request->get('title'),  
            'content' => $request->get('content'),  
            'status' => $request->get('status'),  
            'slug' => Str::slug($request->get('title'))  
        ]);  

        return redirect()->route('post.index')  
            ->with('success', 'Post updated successfully.');  
    }

    public function destroy(Post $post): RedirectResponse  
    {  
        $post->delete();  
        return redirect()  
            ->route('post.index')  
            ->with('success', 'Post deleted successfully.');  
    }
}