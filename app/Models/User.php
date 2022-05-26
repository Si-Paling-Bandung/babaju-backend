<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Feedback;
use App\Models\Favorites;
use App\Models\Histories;
use App\Models\GradeQuiz;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'photo',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'id_user');
    }

    public function favorites()
    {
        return $this->hasMany(Favorites::class, 'id_user');
    }

    public function tracking_lessons()
    {
        return $this->hasMany(TrackingLessons::class, 'id_user');
    }

    public function histories()
    {
        return $this->hasMany(Histories::class, 'id_user');
    }

    public function grade()
    {
        return $this->hasMany(Grade::class, 'id_user');
    }

    public function gradequiz()
    {
        return $this->hasMany(GradeQuiz::class, 'id_user');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class, 'id_user');
    }

    public function userTask()
    {
        return $this->hasMany(UserTask::class, 'id_user');
    }

    public function userCertificate()
    {
        return $this->hasMany(UserCertificate::class, 'id_user');
    }

    public function instance(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Instance::class, 'id_instansi', 'id');
    }

    public function local_officials(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(LocalOfficial::class, 'id_regional_device', 'id');
    }
}
