<?php

namespace App;

use App\Scopes\DeletedScope;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{
    use SoftDeletes;
    // protected $table='blogposts';
    protected $fillable=['title','content', 'user_id'];

    public function comments()
    {
        return $this->hasMany('App\Comment')->latest();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //Start This is a local scope and it read by latest() function in PostController
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT, 'desc');
    }
    //End

    //Start This is a local scope and it read by mostCommented() function  in PostController
    public function scopeMostCommented(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count','desc');
    }
    //End

    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    public static function boot()
    {
        static::addGlobalScope(new DeletedScope);
        parent::boot();

        // static::addGlobalScope(new LatestScope); this is a global scope

        static::deleting(function(BlogPost $blogpost){
            $blogpost->comments()->delete();
        });

        static::updating(function (BlogPost $blogpost){
            Cache::forget("blog-post-{$blogpost->id}");
        });

        static::restoring(function(BlogPost $blogpost){
            $blogpost->comments()->restore();
        }); 
    }

}
