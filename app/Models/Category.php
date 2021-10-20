<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $guarded;

    
    public function tasks()
    {
        return $this->hasMany(Task::class,'category_id');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'category_users', //the pivot table
            'category_id', //this modal id in pivot table
            'user_id', //anthor id for second table
            'id', //id for this table 
            'id' // id for anthor table
        );
    }
}
