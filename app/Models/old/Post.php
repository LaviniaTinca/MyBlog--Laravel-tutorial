<?php
namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;


class Post {
    public $title;
    public $excerpt;
    public $date;
    public $body;
    public $slug;

    /**
     * @param $title
     * @param $excerpt
     * @param $date
     * @param $body
     */
    public function __construct($title, $excerpt, $date, $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug=$slug;
    }

    public static function find($slug){
//        if(!file_exists($path = resource_path("posts/{$slug}.html"))){
//            //return redirect('/');
//            throw new ModelNotFoundException();
//        }
//        return cache()->remember("posts.{$slug}",1200, fn()=> file_get_contents($path));
        //or
        //of all the blog posts, find the one with a slug that matches the one that was requested

        return static::all()->firstWhere('slug', $slug);
        //now we deleted the where clause at the end of the routes so we verify if we acces a null title-page (my-first-post222)
        // $post = static::all()->firstWhere('slug', $slug);
        // if (! $post){
        //     throw new ModelNotFoundException();
        // }
        // return $post;
    }

    public static function findOrFail($slug){
        //now we deleted the where clause at the end of the routes so we verify if we acces a null title-page (my-first-post222)
        //$post = static::all()->firstWhere('slug', $slug); //but we have duplicate  code
        $post = static::find($slug);
        if (! $post){
            throw new ModelNotFoundException();
        }
        return $post;
    }

    public static function all(){
        //return  File::files(resource_path("posts/"));
        //or
//        $files= File::files(resource_path("posts/"));
//        return array_map(fn($file)=>$file->getContents(), $files);
        //or
        return cache()->rememberForever('posts.all', function(){
            return collect(File::files(resource_path("posts")))
                ->map (fn($file)=>YamlFrontMatter::parseFile($file)) //returns a document
                ->map(fn($document)=>
                new Post(
                    $document->title,
                    $document->excerpt,
                    $document->date,
                    $document->body(),
                    $document->slug
                ))->sortByDesc('date'); //so that the newest post appear first
        });
        //this cache is forever, we can check it in terminal with:
        //php artisan tinker
        //cache('posts.all') - we won't be able to see any new posts because of the forever cache
        //cache()->forget('posts.all');

    }
}
