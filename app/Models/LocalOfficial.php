<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class LocalOfficial extends Model
{
    use HasFactory;
    protected $table = 'local_officials';
    protected $primaryKey = 'id';
    protected $fillable = ['title'];

    public function user()
    {
        return $this->hasMany(User::class, 'id_regional_device');
    }
}
