<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class PostController extends Controller
{
    public function index()
    {
        //return  Post::latest()->filter(request(['search', 'category', 'author']))->paginate(6); //ar trebui sa afiseze in format json dar nu...
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

    // public function create()
    // {
    //     // if (auth()->guest()){
    //     //     //abort(403);
    //     //     abort(HttpFoundationResponse::HTTP_FORBIDDEN);
    //     // }
    //     // if (auth()->user()->username <> 'lavinia'){
    //     //     abort(HttpFoundationResponse::HTTP_FORBIDDEN);
    //     // }
    //     return view('admin.posts.create');
    // }

    // // public function store(Request $request)
    // // {
    // //     $path = request()->file('thumbnail')->store('thumbnails');
    // //     $attributes = request()->validate([
    // //         'title' => 'required',
    // //         'slug' => ['required', Rule::unique('posts', 'slug')],
    // //         'excerpt' => 'required',
    // //         'thumbnail' => ['required', 'image'],
    // //         'body' => 'required',
    // //         'category_id' => ['required', Rule::exists('categories', 'id')]
    // //     ]);

    // //     $attributes = $request->except('thumbnail');
    // //     $attributes['user_id'] = auth()->id();

    // //     $post = Post::create($attributes);

    // //     return redirect('/'); //ideally redirect to the post itself
    // // }

    // public function store()
    // {
    //     $attributes = request()->validate([
    //         'title' => 'required',
    //         'slug' => ['required', Rule::unique('posts', 'slug')],
    //         'excerpt' => 'required',
    //         'thumbnail' => ['required', 'image'],
    //         'body' => 'required',
    //         'category_id' => ['required', Rule::exists('categories', 'id')]
    //     ]);

    //     $attributes['user_id'] = auth()->id();
    //     $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
    //     Post::create($attributes);
    //     return redirect('/');
    // }

    //index, show, create, store, edit, update, destroy
}
