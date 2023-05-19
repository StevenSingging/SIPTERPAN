<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $table = 'milestones';
    // protected $guarded = ['id'];
    protected $fillable = ['project_id', 'nama', 'deskripsi', 'mulai', 'jatuh_tempo', 'status','file_id'];

    public function projectm()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'milestone_id', 'id');
    }

    public function getProgress()
    {
        $totalTasks = $this->tasks()->count();
        if ($totalTasks == 0) {
            return 0;
        }
        $completedTasks = $this->tasks()->where('status', '=', '1')->count();
        return round(($completedTasks / $totalTasks) * 100, 2);
    }

    public function filem()
    {
        return $this->belongsTo(file::class,'file_id','id');
    }
}
