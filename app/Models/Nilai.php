<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'marks';
    // protected $guarded = ['id'];
    protected $fillable = ['huruf', 'angka'];
}
