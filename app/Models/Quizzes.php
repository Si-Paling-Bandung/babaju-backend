<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Topics;
use App\Models\GradeQuiz;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quizzes extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'quizzes';
    protected $primaryKey = 'id';
    protected $fillable = ['id_topic','question','answer_1','answer_2','answer_3','answer_4','key','explanation','type'];

    public function topics(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Topics::class, 'id_topic', 'id');
    }

    public function gradequiz()
    {
        return $this->hasMany(GradeQuiz::class, 'id_quiz');
    }
}
