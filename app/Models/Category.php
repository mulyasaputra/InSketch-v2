<?php

namespace App\Models;

use App\Models\App;
use App\Models\Post;
use App\Models\Discover;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
       return 'slug';
    }
    
    public function posts(){
      return $this->hasMany(Post::class);
    }
    public function discovers(){
      return $this->hasMany(Discover::class);
    }
    public function apps(){
      return $this->hasMany(App::class);
    }

    public function sluggable(): array{
      return [
         'slug' => [
               'source' => 'name'
         ]
      ];
    }
}
