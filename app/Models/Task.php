<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $fillable = ['project_id','nama','deskripsi','user_id','mulai','jatuh_tempo','status','milestone_id','file_id'];


    public function milest(){
        return $this->belongsTo(Milestone::class,'milestone_id','id');
    }
    public function projectt(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
    public function filet()
    {
        return $this->belongsTo(file::class,'file_id','id');
    }
}
