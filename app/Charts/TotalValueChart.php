<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Project;
use Symfony\Component\VarDumper\Cloner\Data;

class TotalValueChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // Mengambil data projects dari database
        $projects = Project::where('jatuh_tempo', '<', date('Y-m-d'))->get();

        // Inisialisasi variabel untuk menyimpan jumlah siswa pada setiap grade
        $gradeCounts = ['A' => 0, 'A-' => 0, 'B+' => 0, 'B' => 0, 'B-' => 0, 'C+' => 0, 'C' => 0, 'D' => 0, 'E' => 0];

        // Menghitung jumlah siswa pada setiap grade
        foreach ($projects as $project) {
            $nilai = json_decode($project->nilai);
            foreach ($nilai as $value) {
                switch (true) {
                    case ($value >= 85):
                        $grade = 'A';
                        break;
                    case ($value >= 80):
                        $grade = 'A-';
                        break;
                    case ($value >= 75):
                        $grade = 'B+';
                        break;
                    case ($value >= 70):
                        $grade = 'B-';
                        break;
                    case ($value >= 60):
                        $grade = 'C+';
                        break;
                    case ($value >= 50):
                        $grade = 'C';
                        break;
                    case ($value >= 45):
                        $grade = 'D';
                        break;
                    default:
                        $grade = 'E';
                }
                $gradeCounts[$grade]++;
            }
        }

        // Menyiapkan data untuk chart
        $data = [];
        foreach ($gradeCounts as $grade => $count) {
            $data[] = $count;
        }

        // Membuat chart
        return $this->chart->barChart()
            ->setTitle('Jumlah Nilai pada Semua Project')
            ->addData('Jumlah Nilai', $data)
            ->setXAxis(['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'D', 'E']);
    }
}
