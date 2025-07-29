<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'type',
        'question_group_id', // Add this line
        'education',
    'job_type',
    'qualifications',
      'category', // instead of 'category'
    ];


    public function questions()
{
    return $this->hasMany(JobQuestion::class);
}
public function questionGroup()
{
    return $this->belongsTo(QuestionGroup::class, 'question_group_id');
}


// Job.php model
public function category()
{
    return $this->belongsTo(Category::class);
}



}
