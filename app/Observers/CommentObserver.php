<?php

namespace App\Observers;

use App\Comment;
// use Illuminate\Filesystem\Cache;
use App\BlogPost;
use Illuminate\Support\Facades\Cache;



class CommentObserver
{
    /**
     * Handle the comment "created" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function creating(Comment $comment)
    {
        // dd("I am comment created");
        if ($comment->commentable_type === BlogPost::class) {
            Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}");
            Cache::tags(['blog-post'])->forget('mostCommented');
        }
    }

}
