<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    protected $fillable = ['title', 'content'];
    use HasFactory;

    use SoftDeletes;




    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public static function boot()
    {
        parent::boot();

        // static::deleting(function(BlogPost $blogPost){
        //     // dd('I was deleted');
        //     $blogPost->comments()->delete();
        // });
    }




}
