<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Tag extends Model
{
    protected $fillable = ['tag_id'];

    public function posts(){
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function posvideosts(){
        return $this->morphedByMany(Video::class, 'taggable');
    }
}