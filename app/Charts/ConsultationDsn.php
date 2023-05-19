<?php

namespace App\Charts;

use App\Models\Consultation;
use App\Models\Project;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class ConsultationDsn
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($id): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $project = Project::where('id',$id)->first();
        $consultations = Consultation::select('mahasiswa')
            ->selectRaw('GROUP_CONCAT(mahasiswa) as mahasiswa')
            ->where('project_id',$project->id)
            ->groupBy('mahasiswa')
            ->get();

        $mahasiswasCounts = [];
        $mahasiswas = [];

        foreach ($consultations as $consultation) {
            $mahasiswaArray = json_decode($consultation->mahasiswa, true); // Ubah menjadi array
            foreach ($mahasiswaArray as $mahasiswa) {
                if (!isset($mahasiswasCounts[$mahasiswa])) {
                    $mahasiswasCounts[$mahasiswa] = 0;
                }
                $mahasiswasCounts[$mahasiswa]++;
                $mahasiswas[] = $mahasiswa;
            }
        }

        return $this->chart->barChart()
            ->setTitle('Konsultasi')
            ->addData('Jumlah Konsultasi', array_values($mahasiswasCounts))
            ->setColors(['#ffc63b',])
            ->setXAxis($mahasiswas);
    }
}
