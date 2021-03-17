<?php

namespace App\Listeners;

use App\Events\CommentPosted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Jobs\ThrottledMail;
use App\Mail\CommentPostedMarkdown;

class NotifyUsersAboutComment
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CommentPosted $event)
    {
        // dd('event called');
        
        ThrottledMail::dispatch(new CommentPostedMarkdown($event->comment), 
        $event->comment->commentable->user)
            ->onQueue('low');

        NotifyUsersPostWasCommented::dispatch($event->comment)
            ->onQueue('high');
    }
}
