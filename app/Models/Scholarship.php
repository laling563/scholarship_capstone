<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Scholarship extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'requirements',
        'status',
        'budget',
        'grant_amount',
        'start_date',
        'end_date',
        'student_limit',
        'sponsor_id',
        'accepted_students',
    ];

    protected $casts = [
    ];

    protected $primaryKey = 'scholarship_id';

    public function applicationForms() {
        return $this->hasMany(ApplicationForm::class, 'scholarship_id', 'scholarship_id');
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
}
