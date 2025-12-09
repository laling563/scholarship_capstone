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
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the requirements attribute, ensuring it is always an array.
     *
     * @param  mixed  $value
     * @return array
     */
    public function getRequirementsAttribute($value)
    {
        if (empty($value)) {
            return [];
        }

        if (is_string($value)) {
            $data = json_decode($value, true);
            // Check if it was valid JSON
            if (json_last_error() === JSON_ERROR_NONE) {
                return is_array($data) ? $data : [$data];
            }
            // If not valid JSON, treat it as a plain string
            return [$value];
        }

        if (is_array($value)) {
            return $value;
        }

        // Fallback for other unexpected types
        return [];
    }

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }

    public function applicationForms()
    {
        return $this->hasMany(ApplicationForm::class, 'scholarship_id');
    }
}
