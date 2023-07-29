<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['user_id','project_id','judul','mahasiswa'];

    public function projectn(){
        return $this->belongsTo(Project::class,'project_id');
    }
    public function usern(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    
}
