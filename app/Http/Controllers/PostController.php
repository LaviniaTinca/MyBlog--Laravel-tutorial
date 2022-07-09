<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            //'posts'=> Post::latest()->filter()->get(),
            'posts' => Post::latest()->filter(request(['search', 'category', 'author']))->paginate(6),
            'categories' => Category::all(),  // I don't need this anymore since I have CategoryDropdown
            //'currentCategory' => Category::where('slug', request('category'))->first()
        ]);

        // $posts = Post::latest();
        // if (request('search')) {
        //     $posts
        //         ->where('title', 'like', '%' . request('search') . '%');
        //         //->orWhere('body', 'like', '%' . request('search') . '%');
        // }
        // return view('post', [
        //     'posts' => $posts->get(),
        //     'categories' => Category::all()
        // ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }
}
