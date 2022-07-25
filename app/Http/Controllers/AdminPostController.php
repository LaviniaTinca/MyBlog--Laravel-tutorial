<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::paginate(50),
        ]);
    }

    //    public function show(Post $post)
    //     {
    //         return view('posts.show', [
    //             'post' => $post
    //         ]);
    //     }

    public function create()
    {
        // if (auth()->guest()){
        //     //abort(403);
        //     abort(HttpFoundationResponse::HTTP_FORBIDDEN);
        // }
        // if (auth()->user()->username <> 'lavinia'){
        //     abort(HttpFoundationResponse::HTTP_FORBIDDEN);
        // }
        return view('admin.posts.create');
    }

    // public function store(Request $request)
    // {
    //     $path = request()->file('thumbnail')->store('thumbnails');
    //     $attributes = request()->validate([
    //         'title' => 'required',
    //         'slug' => ['required', Rule::unique('posts', 'slug')],
    //         'excerpt' => 'required',
    //         'thumbnail' => ['required', 'image'],
    //         'body' => 'required',
    //         'category_id' => ['required', Rule::exists('categories', 'id')]
    //     ]);

    //     $attributes = $request->except('thumbnail');
    //     $attributes['user_id'] = auth()->id();

    //     $post = Post::create($attributes);

    //     return redirect('/'); //ideally redirect to the post itself
    // }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'slug' => ['required', Rule::unique('posts', 'slug')],
            'excerpt' => 'required',
            'thumbnail' => ['required', 'image'],
            'body' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'id')]
        ]);

        $attributes['user_id'] = auth()->id();
        $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        Post::create($attributes);
        return redirect('/');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', ['post' => $post]);
    }

    public function update(Post $post)
    {
        $attributes = request()->validate([
            'title' => 'required',
            'thumbnail' => 'image',
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post->id)],
            'excerpt' => 'required',
            'body' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'id')]
        ]);

        if (isset($attributes['thumbnail'])) {
            $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        }

        $post->update($attributes);

        return back()->with('success', 'Post Updated!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('success', 'Post Deleted!');
    }

}
