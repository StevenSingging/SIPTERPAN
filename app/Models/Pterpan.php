<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pterpan extends Model
{
    protected $table = 'pterpans';
    protected $fillable = ['no_induk','name','status','pengambilan','tahun_ajaran'];

    public function pterpans(){
        return $this->hasOne(User::class,'no_induk','id');
    }
}

