<?php

use App\Models\Post;
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

Route::get('/', function () {
    $files = File::files(resource_path("posts"));
    //1.a  with collectors
    $posts = collect(File::files(resource_path("posts")))
        ->map (fn($file)=>YamlFrontMatter::parseFile($file)) //returns a document
        ->map(fn($document)=>
             new Post(
                $document->title,
                $document->excerpt,
                $document->date,
                $document->body(),
                $document->slug
            ));



    //1.b with collectors
    //$posts = collect($files)
//    $posts = collect(File::files(resource_path("posts")))
//        ->map(function($file){
//            $document = YamlFrontMatter::parseFile($file);
//            return new Post(
//                $document->title,
//                $document->excerpt,
//                $document->date,
//                $document->body(),
//                $document->slug
//            );
//        });

    //2. with array_map
//    $posts = array_map(function ($file){
//        $document = YamlFrontMatter::parseFile($file);
//        return new Post(
//            $document->title,
//            $document->excerpt,
//            $document->date,
//            $document->body(),
//            $document->slug
//        );
//    }, $files);

    //3. with foreach
//    $posts = [];
//    foreach ($files as $file){
//        $document = YamlFrontMatter::parseFile($file);
//        $posts[] = new Post(
//            $document->title,
//            $document->excerpt,
//            $document->date,
//            $document->body(),
//            $document->slug
//        );
//    }
    //dd($posts[2]->slug); //  sare o exceptie mereu cu ddd


    return view('posts',[
        'posts'=> Post::all()
    ]);
});

Route::get('posts/{post}', function($slug){ //{post} now its a wildcard
    //Find a post by its slug and pass it to a view called "post"
    //$post = Post::find($slug);
    $post = Post::findOrFail($slug);
    return view('post',[
        'post'=>$post
    ]);
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
});//->where('post', '[A-z_\-]+'); //adding constraint
//->whereAlpha('post');
