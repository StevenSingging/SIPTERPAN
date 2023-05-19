<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'periods';
    // protected $guarded = ['id'];
    protected $fillable = ['tahun_ajaran', 'tgl_awal', 'tgl_akhir', 'status'];
}
