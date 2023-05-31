<?php

namespace App\Charts;

use App\Models\Project;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class YearProjectChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $query = Project::selectRaw('count(*) as count, tahun_ajaran, status')
            ->groupBy('tahun_ajaran', 'status');

        $project = Project::leftJoinSub($query, 'project_count', function ($join) {
            $join->on('projects.tahun_ajaran', '=', 'project_count.tahun_ajaran')
                ->on('projects.status', '=', 'project_count.status');
        })
            ->select('projects.tahun_ajaran', 'projects.status', DB::raw('IFNULL(project_count.count, 0) as count'))
            ->orderBy('projects.tahun_ajaran', 'ASC')
            ->orderBy('projects.status', 'ASC')
            ->get();

        $tahunAjaran = $project->pluck('tahun_ajaran')->unique()->values();
        $statuses = ['0', '1','2'];

        $data = [];
        foreach ($statuses as $status) {
            $data[$status] = $tahunAjaran->map(function ($tahun) use ($status, $project) {
                return $project->where('tahun_ajaran', $tahun)->where('status', $status)->sum('count');
            })->toArray();
        }
        //dd($data2);
        // Menghapus data yang duplikat pada X Axis
        $xAxis = $project->map(function ($p) {
            return substr($p->tahun_ajaran, 0, 4) . ((int) substr($p->tahun_ajaran, -1) % 2 == 0 ? ' Genap' : ' Ganjil');
        })->toArray();
        return $this->chart->barChart()
            ->setTitle('Jumlah Project setiap Tahun Ajaran')
            ->addData('Project dalam progress', $data['0'])
            ->addData('Project selesai', $data['1'])
            ->addData('Project gagal', $data['2'])
            ->setColors(['#ffc63b', '#00E396','#FF455F'])
            ->setXAxis($xAxis);
    }
}
