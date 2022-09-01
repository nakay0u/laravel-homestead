<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
