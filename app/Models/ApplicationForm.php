<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ApplicationForm extends Model
{

    use HasFactory, SoftDeletes;

    protected $primaryKey = 'applicationform_id';

    protected $fillable = [
        'scholarship_id',
        'student_id',
        'date_of_birth',
        'civil_status',
        'place_of_birth',
        'religion',
        'height',
        'weight',
        'home_address',
        'contact_address',
        'boarding_address',
        'landlord_landlady',
        'high_school_graduated',
        'high_school_year_graduated',
        'special_skills',
        'curriculum_year',
        'father_first_name',
        'father_middle_name',
        'father_last_name',
        'father_occupation',
        'father_monthly_income',
        'father_educational_attainment',
        'father_school_graduated',
        'father_year_graduated',
        'mother_first_name',
        'mother_middle_name',
        'mother_last_name',
        'mother_occupation',
        'mother_monthly_income',
        'mother_educational_attainment',
        'mother_school_graduated',
        'mother_year_graduated',
        'number_of_brothers',
        'number_of_sisters',
        'total_monthly_income',
        'status',
        'submission_date',
        'notes'
    ];

    /**
     * Get the scholarship that owns the application form.
     */
    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'scholarship_id', 'scholarship_id');
    }

    /**
     * Get the student that owns the application form.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the documents for the application form.
     */
    public function documents()
    {
        return $this->hasMany(ApplicationDocument::class, 'applicationform_id');
    }
}
