<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =[
        'name', 'label'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    // sentence-capitalise different variables
     public function getNameAttribute($desc)
     {
         return ucwords($desc);
     }
}
