<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scholarship;
use App\Models\Student;
class Application extends Model
{
    protected $fillable = [
        'student_id',
        'scholarship_id',
        'status',
        'remarks',
    ];
// In ApplicationForm model
public function student()
{
    return $this->belongsTo(Student::class);
}

public function scholarship()
{
    return $this->belongsTo(Scholarship::class);
}

}
