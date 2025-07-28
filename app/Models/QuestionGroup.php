<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\JobQuestion;

class QuestionGroup extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function questions()
    {
        return $this->hasMany(JobQuestion::class, 'group_id');
    }
}
