<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $primaryKey = 'scholarship_id';

    protected $fillable = [
        'title',
        'description',
        'grant_amount',
        'sponsor_id',
        'requirements',
        'start_date',
        'end_date',
        'budget',
        'student_limit',
        'type',
        'sport_type',
        'skill_level',
        'income_bracket',
        'dependency_status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'requirements' => 'array',
    ];

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function applicationForms()
    {
        return $this->hasMany(ApplicationForm::class, 'scholarship_id');
    }
}
