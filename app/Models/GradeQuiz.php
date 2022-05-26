<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Quizzes;

class GradeQuiz extends Model
{
    use HasFactory;
    protected $table = 'grade_quizzes';
    protected $primaryKey = 'id';
    protected $fillable = ['id_user', 'id_quiz', 'user_answer','is_right'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function quizzes(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Quizzes::class, 'id_quiz', 'id');
    }
}
