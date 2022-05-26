<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Topics;
use App\Models\Lessons;
use Illuminate\Database\Eloquent\SoftDeletes;

class LOs extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'l_os';
    protected $primaryKey = 'id';
    protected $fillable = ['id_topic','name'];

    public function topics(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Topics::class, 'id_topic', 'id');
    }

    public function lessons()
    {
        return $this->hasMany(Lessons::class, 'id_lo');
    }
}
