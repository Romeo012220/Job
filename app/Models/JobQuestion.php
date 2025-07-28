<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'group_id'];

    public function group()
    {
        return $this->belongsTo(QuestionGroup::class, 'group_id');
    }
}
