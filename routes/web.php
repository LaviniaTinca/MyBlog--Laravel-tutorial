<?php

use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Route;
//use \Spatie\YamlFrontMatter\YamlFrontMatter;
use Spatie\YamlFrontMatter\YamlFrontMatter;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     // $files = File::files(resource_path("posts"));
//     // //1.a  with collectors
//     // $posts = collect(File::files(resource_path("posts")))
//     //     ->map (fn($file)=>YamlFrontMatter::parseFile($file)) //returns a document
//     //     ->map(fn($document)=>
//     //          new Post(
//     //             $document->title,
//     //             $document->excerpt,
//     //             $document->date,
//     //             $document->body(),
//     //             $document->slug
//     //         ));



//     //1.b with collectors
//     //$posts = collect($files)
//     //    $posts = collect(File::files(resource_path("posts")))
//     //        ->map(function($file){
//     //            $document = YamlFrontMatter::parseFile($file);
//     //            return new Post(
//     //                $document->title,
//     //                $document->excerpt,
//     //                $document->date,
//     //                $document->body(),
//     //                $document->slug
//     //            );
//     //        });

//     //2. with array_map
//     //    $posts = array_map(function ($file){
//     //        $document = YamlFrontMatter::parseFile($file);
//     //        return new Post(
//     //            $document->title,
//     //            $document->excerpt,
//     //            $document->date,
//     //            $document->body(),
//     //            $document->slug
//     //        );
//     //    }, $files);

//     //3. with foreach
//     //    $posts = [];
//     //    foreach ($files as $file){
//     //        $document = YamlFrontMatter::parseFile($file);
//     //        $posts[] = new Post(
//     //            $document->title,
//     //            $document->excerpt,
//     //            $document->date,
//     //            $document->body(),
//     //            $document->slug
//     //        );
//     //    }
//     //dd($posts[2]->slug); //  sare o exceptie mereu cu ddd


//     return view('posts', [
//         //'posts'=>Post::all()
//         //'posts' => Post::latest()->with('category', 'author')->get()
//         'posts' => Post::latest()->get(), //we added the attribute $with in Post (we need those categories to optimize - clockwork)
//         'categories' => Category::all()
//     ]);
// });




//Route::get('posts/{post}', function($id){ //{post} now its a wildcard
//note: The Eloquent class works with id not slug
//Find a post by its slug and pass it to a view called "post"
//$post = Post::find($slug);



// $post = Post::findOrFail($id);
// return view('post',[
//     'post'=>$post
// ]);




// $path =__DIR__. "/../resources/posts/{$slug}.html";
// //ddd($path);
// if (!file_exists($path)){
//     //ddd("file doesn't exist");
//     return redirect("/");
// }

// $post = cache()->remember("posts.{$slug}", 5, function() use ($path){
//     //here we cache for 5 seconds but we can now()->addMinutes(20)
//     //we use cache when are 10000 loads of the same path in short time
//     var_dump('file_get_contents');
//     return file_get_contents($path);
// });
// //$post = file_get_contents($path);
// return view('post', [
//     'post'=>$post
//]);
//});//->where('post', '[A-z_\-]+'); //adding constraint
//->whereAlpha('post');



//for the LARAVEL BLOG!!!!!!!




Route::get('/', [PostController::class, 'index'])->name('home');  

// Route::get('/', function(){
//     $posts = Post::latest();
//     if (request('search')){
//         $posts->where('title', 'like', '%'.request('search').'%');

//     }
//     return view('posts', [
//         'posts'=>$posts->get(),
//         'categories'=>Category::all()
//     ]);
// });


Route::get('posts/{post:slug}', [PostController::class, 'show']);


//Route model binding - the wildcard must mach !!!! the parameter
// Route::get('posts/{post:slug}', function (Post $post) {
//     return view('post', [
//         'post' => $post
//     ]);
// });

//after we implemented the filter we don't need this route
Route::get('categories/{category:slug}', function (Category $category) {
    return view('posts.index', [
        // 'posts' => $category->posts->load(['category', 'author'])
        'posts' => $category->posts,  //we added the attribute $with in Post (we need those categories to optimize - clockwork)
        //'currentCategory' => $category,
        'categories' => Category::all() //i don't need this anymore since I have CategoryDropdown
    ]);
});

Route::get('authors/{author:username}', function (User $author) {
    return view('posts.index', [
        //  'posts' => $author->posts->load(['category', 'author'])
        'posts' => $author->posts, //we added the attribute $with in Post (we need those categories to optimize - clockwork)
        'categories' => Category::all()
    ]);
});

Route::post('posts/{post:slug/comments}', [PostCommentsController::class, 'store'] );

Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class, 'create'])->middleware('guest');
Route::post('login', [SessionsController::class, 'store']);

Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');
