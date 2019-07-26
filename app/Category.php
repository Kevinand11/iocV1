<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function subs()
    {
        return $this->hasMany('App\Category','parent_id',"id");
    }

    public function parent()
    {
        return $this->hasOne('App\Category', 'id', 'parent_id');
    }    
    
}
