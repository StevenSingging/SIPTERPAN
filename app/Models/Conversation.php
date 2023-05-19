<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversations';
    // protected $guarded = ['id'];
    protected $fillable = ['user_id','judul','text','file_id','project_id'];

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function file()
    {
        return $this->belongsTo(file::class,'file_id');
    }

}
