<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserCertificate;

class Certificate extends Model
{
    use HasFactory;
    protected $table = 'certificates';
    protected $primaryKey = 'id';
    protected $fillable = ['id_topic', 'number', 'file'];

    public function topics(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Topics::class, 'id_topic', 'id');
    }
}
