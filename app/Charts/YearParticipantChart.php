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
        // $tahun_ajaran = History::distinct('tahun_ajaran')->pluck('tahun_ajaran')->toArray();
        // $jumlah_peserta = [];
        // foreach ($tahun_ajaran as $tahun) {
        //     $tahun_label = substr($tahun, 0, -1);
        //     $semester_label = (int) substr($tahun, -1) % 2 == 0 ? 'Genap' : 'Ganjil';

        //     $jumlah_peserta[] = History::where('tahun_ajaran', $tahun)->count('no_induk');
        //     $tahun_ajaran_label[] = $tahun_label . ' ' . $semester_label;
        // }
        $tahun_ajaran = History::distinct('tahun_ajaran')->pluck('tahun_ajaran')->toArray();
        $jumlah_peserta = [];
        $tahun_ajaran_label = [];

        foreach ($tahun_ajaran as $tahun) {
            $tahun_label = substr($tahun, 0, -1);
            $semester_label = (int) substr($tahun, -1) % 2 == 0 ? 'Genap' : 'Ganjil';

            $jumlah = History::where('tahun_ajaran', $tahun)->count('no_induk');
            $jumlah_peserta[] = $jumlah;
            $tahun_ajaran_label[] = $tahun_label . ' ' . $semester_label;

            if ($jumlah === 0) {
                $jumlah_peserta[] = 0;
                $tahun_ajaran_label[] = $tahun_label . ' ' . $semester_label;
            }
        }
        return $this->chart->barChart()
            ->setTitle('Jumlah Peserta tiap Tahun Ajaran')
            ->addData('Jumlah Peserta', $jumlah_peserta)
            ->setXAxis($tahun_ajaran_label);
    }
}
