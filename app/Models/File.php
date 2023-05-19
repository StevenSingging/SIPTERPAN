<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';
    //protected $guarded = ['id'];
    protected $fillable = ['project_id','file_name','file_path'];

    public function converfile()
    {
        return $this->hasMany(Conversation::class,'file_id','id');
    }

}
