<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['job_application_id', 'job_question_id', 'answer'];

// app/Models/JobAnswer.php
public function application()
{
    return $this->belongsTo(JobApplication::class, 'job_application_id');
}

// app/Models/JobAnswer.php
// app/Models/JobAnswer.php
public function question()
{
    return $this->belongsTo(JobQuestion::class, 'job_question_id');
}



}
