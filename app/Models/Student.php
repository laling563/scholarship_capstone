<?php

namespace App\Models;
use HasApiTokens, HasFactory, Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
    public function applicationForms() {
        return $this->hasMany(ApplicationForm::class);
    }
    
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'student_id',
        'sex',
        'course',
        'year_level',
        'email',
        'password',
    ];
    

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
