<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job;
use App\Models\JobAnswer;

class JobApplication extends Model
{
    use HasFactory;

    protected $table = 'applications'; // <== ✅ Add this line

    protected $fillable = [
        'job_id',
        'user_id',
        'name',
        'email',
        'cover_letter',
        'resume_path',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function answers()
    {
        return $this->hasMany(JobAnswer::class);
    }
}
