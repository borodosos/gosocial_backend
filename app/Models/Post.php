<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'image',
        'user_id'
    ];


    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('comments', function ($builder) {
    //         $builder->with('comments');
    //     });
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'comment');
    }
}