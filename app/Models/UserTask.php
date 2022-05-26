<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Topics;
use App\Models\Task;

class UserTask extends Model
{
    use HasFactory;
    protected $table = 'user_tasks';
    protected $primaryKey = 'id';
    protected $fillable = ['id_topic', 'id_user', 'id_task', 'file', 'user_notes'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function topics(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Topics::class, 'id_topic', 'id');
    }

    public function task(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Task::class, 'id_task', 'id');
    }
}
