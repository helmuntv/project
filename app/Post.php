<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Post extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'author', 
        'description',
    ];

    public function scopeActive($query){
        return $query->where('active', 1);
    }

    public function getNameAttribute($value){
        return strtoupper($value);
    }

    public function getDescriptionAttribute($value){
        return strtolower($value);
    }

    public function setDescriptionAttribute($value){
        $this->attributes['description'] = ucwords($value);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }
}