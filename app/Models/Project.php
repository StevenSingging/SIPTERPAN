<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'mulai', 'jatuh_tempo', 'mahasiswa1', 'mahasiswa2', 'mahasiswa3', 'dosen','semester','tahun_ajaran', 'status','nilai'];


    public function project()
    {
        return $this->hasMany(Project::class, 'id_project', 'id');
    }

    public function milestone()
    {
        return $this->hasMany(Milestone::class, 'project_id', 'id');
    }

    public function task()
    {
        return $this->hasMany(Task::class, 'project_id', 'id');
    }

    public function notif()
    {
        return $this->hasMany(Notification::class, 'project_id');
    }

    public function konsul()
    {
        return $this->hasMany(Consultation::class, 'project_id', 'id');
    }

    public function getmenu()
    {
        $menu = DB::select('select * from projects where status = ?', ['0']);

        return ['menu' => $menu];
    }

    public function dataMhs($id)
    {
        // return DB::table('projects')
        //     ->leftJoin('pterpans', 'pterpans.no_induk', '=', 'projects.mahasiswa1', 'projects.mahasiswa2', 'projects.mahasiswa3')

        //     ->where('projects.id', $id)
        //     ->first();
            // return DB::table('projects')
            // ->leftJoin('pterpans', function ($join) {
            //     $join->on('pterpans.no_induk', '=', 'projects.mahasiswa1')
                    
            //         ;
            // })
            // ->where('projects.id',$id)
            // ->select('pterpans.name')
            // ->get();

            $sql = DB::table('projects')
            ->select('pterpans.name', 'projects.nama')
            ->join('pterpans', function($join) {
                $join->on('pterpans.no_induk', '=', 'projects.mahasiswa1')
                     ->orOn('pterpans.no_induk', '=', 'projects.mahasiswa2')
                     ->orOn('pterpans.no_induk', '=', 'projects.mahasiswa3');
            })
            ->union(DB::table('pterpans')
                     ->select('name', DB::raw('NULL AS nama_project'))
                     ->whereNotIn('no_induk', function($query) {
                        $query->select('mahasiswa1')->from('projects')
                            ->union(DB::select('select `mahasiswa2` from `projects`'))
                            ->union(DB::select('select `mahasiswa3` from `projects`'));
                    }))
            ->toSql();

            //echo $sql;
            return $sql;

            $pterpans = Pterpan::select('name', DB::raw('NULL AS nama_project'))
            ->whereNotIn('no_induk', function ($query) {
                $query->select('mahasiswa1','mahasiswa2','mahasiswa3')->from('projects');
            });
    }

    
}
