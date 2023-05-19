<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation_Replies extends Model
{
    protected $table = 'conversations_replies';
    // protected $guarded = ['id'];
    protected $fillable = ['conversation_id','user_id','text','file_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function file()
    {
        return $this->belongsTo(file::class,'file_id');
    }
}
