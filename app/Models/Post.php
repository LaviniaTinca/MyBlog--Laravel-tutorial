<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    //protected $fillable=['title', 'excerpt', 'body', 'category_id', 'slug']; //just these are fillable
    protected $guarded = ['id'];  //all are fillable except id
    //we add ths attribute - >now check in routes
    protected $with = ['category', 'author'];

    public function scopeFilter1($query, array $filters) // Post::newQuery()->filter() //asta era varianta initiala care merge
    {
        if ($filters['search'] ?? false) {
            $query
                ->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('body', 'like', '%' . request('search') . '%');
        }
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(fn($query)=>
                $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('body', 'like', '%' . request('search') . '%'));
        });
    //     $query->when($filters['category'] ?? false, fn($query, $category)=>
    //         $query
    //             ->whereExists(fn($query)=>
    //             $query->from('categories')
    //                 ->whereColumn('categories', 'posts.category_id')
    //                 ->where('categories.slug', $category))      
    // );
            $query->when($filters['category'] ?? false, fn($query, $category)=>
            $query
                ->whereHas('category', fn($query) => 
                    $query->where('slug', $category))
            );
            $query->when($filters['author'] ?? false, fn($query, $author)=>
            $query
                ->whereHas('author', fn($query) => 
                    $query->where('username', $author))
            );
    }



    //eloquent relationship
    public function category()
    {
        //hasOne, hasMany, belongsTo, belongsToMany
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
