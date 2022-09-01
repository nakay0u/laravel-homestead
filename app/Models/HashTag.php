<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HashTag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function tweets()
    {
        return $this->belongsToMany(Tweet::class);
    }
}
