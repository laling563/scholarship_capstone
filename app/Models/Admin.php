<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'faculty_id',
        'fname',
        'lname',
        'email',
        'password',
        'role',
    ];

    // Optionally, you can hide sensitive fields (like the password) from the model's array or JSON representation
    protected $hidden = [
        'password',
    ];
}
