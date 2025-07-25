<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'name',
        'email',
        'cover_letter',
        'resume',
    ];

    // Add this relationship
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
