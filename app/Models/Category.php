<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $gaurded = [];

    public function todo()
    {
        return $this->hasMany(Todo::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
