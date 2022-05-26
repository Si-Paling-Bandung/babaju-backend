<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Lessons;

class TrackingLessons extends Model
{
    use HasFactory;
    protected $table = 'tracking_lessons';
    protected $primaryKey = 'id';
    protected $fillable = ['id_user', 'id_lesson'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function lesson(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Lessons::class, 'id_lesson', 'id');
    }
}
