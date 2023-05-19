<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Logbook;
use App\Models\Project;
class LogbookMhs
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($id): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $project = Project::where('id',$id)->first();
        $logbooks = Logbook::where(['project_id' => $project->id,'mahasiswa' => auth()->user()->no_induk])
            ->selectRaw('DATE_FORMAT(tgl_logbook, "%D/%M/%Y") as tanggal, COUNT(*) as jumlah_logbook')
            ->groupBy('tanggal')
            ->get();

        $tanggal = $logbooks->pluck('tanggal')->toArray();
        $jumlahLogbook = $logbooks->pluck('jumlah_logbook')->toArray();

        return $this->chart->lineChart()
        ->setTitle('Jumlah Logbook per Tanggal')
        ->addData('Jumlah Logbook', $jumlahLogbook)
        ->setXAxis($tanggal);
    }
}
