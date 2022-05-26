<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LOs;
use App\Models\Feedback;
use App\Models\Certificate;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topics extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'topics';
    protected $primaryKey = 'id';

    public function histories()
    {
        return $this->hasMany(Histories::class, 'id_topic');
    }

    public function los()
    {
        return $this->hasMany(LOs::class, 'id_topic');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'id_topic');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class, 'id_topic');
    }

    public function task()
    {
        return $this->hasMany(Task::class, 'id_topic');
    }

    public function certificate()
    {
        return $this->hasMany(Certificate::class, 'id_topic');
    }

    public function quizzes()
    {
        return $this->hasMany(Quizzes::class, 'id_topic');
    }

    public function grade()
    {
        return $this->hasMany(Grade::class, 'id_topic');
    }

    public function userTask()
    {
        return $this->hasMany(UserTask::class, 'id_topic');
    }

    public function userCertificate()
    {
        return $this->hasMany(UserCertificate::class, 'id_topic');
    }
}
