<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $table = 'consultations';
    // protected $guarded = ['id'];
    protected $fillable = ['project_id','tgl_konsul','name','deskripsi','mahasiswa'];

    public function projectk(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
}
