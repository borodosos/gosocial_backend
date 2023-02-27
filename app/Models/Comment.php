<?php

namespace App\Models;

use App\CommentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'user_id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replies', function ($builder) {
            $builder->with('replies.user');
        });
        static::addGlobalScope('user', function ($builder) {
            $builder->with('user');
        });

        static::deleting(function ($item) {
            if (!$item->replies->isEmpty()) {
                $item->replies()->delete();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}