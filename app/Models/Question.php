<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\QuestionGroup;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_group_id',
        'question_text',
    ];

    public function group()
    {
        return $this->belongsTo(QuestionGroup::class, 'question_group_id');
    }
}
