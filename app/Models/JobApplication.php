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
    'user_id',          // <== ADD THIS
    'name',
    'email',
    'cover_letter',
    'resume_path',      // Make sure this matches the column name in DB
];



    // Add this relationship
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
