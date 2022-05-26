<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Instance extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'instances';
    protected $primaryKey = 'id';
    protected $fillable = ['title'];

    public function user()
    {
        return $this->hasMany(User::class, 'id_instansi');
    }
}
