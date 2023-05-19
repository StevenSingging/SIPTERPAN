<?php

namespace App\Charts;
use App\Models\History;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class YearParticipantChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $tahun_ajaran = History::distinct('tahun_ajaran')->pluck('tahun_ajaran')->toArray();
        $jumlah_peserta = [];
        foreach ($tahun_ajaran as $tahun) {
            $jumlah_peserta[] = History::where('tahun_ajaran', $tahun)->count('no_induk');
        }
        return $this->chart->barChart()
            ->setTitle('Jumlah Peserta tiap Tahun Ajaran')
            ->addData('Jumlah Peserta',$jumlah_peserta)
            ->setXAxis($tahun_ajaran);
    }
}
