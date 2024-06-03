<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $fillable = [
        'name'
    ];
    use HasFactory;
    public function posts()
    {
        return $this->hasMany(post::class);
    }
}

