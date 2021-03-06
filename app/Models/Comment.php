<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Table
    protected $table = 'comments';

    // Fillable
    protected $fillable = [
        'user_id',
        'post_id',
        'content'
    ];

    // Belong to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Belong to post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public static function getCommentOfCategory($category)
    {
        $total = 0;
        foreach ($category->posts as $post) {
            $total += count($post->comments);
        }
        return $total;
    }

    public static function getComments($post, $total = 6)
    {
        $comments = Comment::with('user')
            ->where('post_id', '=', $post->id)
            ->orderBy('created_at', 'desc')
            ->take($total)
            ->get();
        $result = $comments->reverse();
        return $result;
    }

    public static function getNextComments($post, $total)
    {
        $total += 6;
        $comments = Comment::with('user')
            ->where('post_id', '=', $post->id)
            ->orderBy('created_at', 'desc')
            ->take($total)
            ->get();
        $result = $comments->reverse();
        return $result;
    }
}
