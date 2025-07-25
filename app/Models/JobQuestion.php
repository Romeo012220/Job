<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobQuestion extends Model
{
    protected $fillable = ['job_id', 'question'];

public function job()
{
    return $this->belongsTo(Job::class);
}

}
