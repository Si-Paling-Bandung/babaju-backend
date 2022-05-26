<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LOs;
use App\Models\Quizzes;
use App\Models\Favorites;
use App\Models\Histories;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lessons extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'lessons';
    protected $primaryKey = 'id';
    protected $fillable = ['id_lo','name','video_url','video_duration','lesson_text','lesson_attachment'];

    public function los(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(LOs::class, 'id_lo', 'id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorites::class, 'id_lesson');
    }

    public function histories()
    {
        return $this->hasMany(Histories::class, 'id_lesson');
    }
}
