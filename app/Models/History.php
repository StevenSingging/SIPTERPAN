<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'histories';
    // protected $guarded = ['id'];
    protected $fillable = ['nama', 'no_induk', 'tahun_ajaran',];
}
