<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Topics;

class Grade extends Model
{
    use HasFactory;
    protected $table = 'grades';
    protected $primaryKey = 'id';
    protected $fillable = ['id_user', 'id_topic', 'type', 'grade'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function topic(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Topics::class, 'id_topic', 'id');
    }
}