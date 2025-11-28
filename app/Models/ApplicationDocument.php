<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class ApplicationDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicationform_id',
        'document_type',
        'file_name',
        'file_path',
        'notes'
    ];

    /**
     * Get the application form that owns the document.
     */
    public function applicationForm()
    {
        return $this->belongsTo(ApplicationForm::class, 'applicationform_id', 'applicationform_id');
    }
    public function application()
    {
        return $this->belongsTo(ApplicationForm::class, 'applicationform_id');
    }

}