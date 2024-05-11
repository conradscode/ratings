<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    const LIKE_ACTIVE = 1;

    protected $fillable = [
        '_fk_user', '_fk_location', 'like_active'
    ];
}
