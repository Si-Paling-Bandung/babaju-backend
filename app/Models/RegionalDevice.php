<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegionalDevice extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'regional_devices';
    protected $primaryKey = 'id';
    protected $fillable = ['title'];
}
