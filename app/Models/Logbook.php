<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Request;

class Logbook extends Model
{
    protected $table = 'logbooks';
    // protected $guarded = ['id'];
    protected $fillable = ['mahasiswa', 'project_id', 'tgl_logbook', 'kegiatan', 'deskripsi'];

    public function projectl()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    
}
