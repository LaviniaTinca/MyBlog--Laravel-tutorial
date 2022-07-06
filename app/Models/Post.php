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
