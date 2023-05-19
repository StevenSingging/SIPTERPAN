<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Milestone;
use App\Models\Project;
class MilestoneDsn
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($id): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        $project = Project::where('id',$id)->first();
        $milestoneCount = Milestone::where('project_id',$project->id)->count();
        if ($milestoneCount === 0) {
            return $this->chart->donutChart()
            ->setTitle('Milestone')
            ->addData([])
            ->setColors(['#ffc63b', '#00E396','#FF455F'])
            ->setLabels(['Dalam Progress', 'Selesai', 'Gagal']);
        }
        
        $onProgressCount = Milestone::where(['project_id' => $project->id,'status' => '0'])->count();
        $selesaiCount = Milestone::where(['project_id' => $project->id,'status' => '1'])->count();
        $gagalCount = Milestone::where(['project_id' => $project->id,'status' => '2'])->count();
    
        $onProgressPercentage = intval(($onProgressCount / $milestoneCount) * 100);
        $selesaiPercentage = intval(($selesaiCount / $milestoneCount) * 100);
        $gagalPercentage = intval(($gagalCount / $milestoneCount) * 100);

        return $this->chart->donutChart()
            ->setTitle('Milestone')
            ->addData([$onProgressCount, $selesaiCount, $gagalCount])
            ->setColors(['#ffc63b', '#00E396','#FF455F'])
            ->setLabels(['Dalam Progress', 'Selesai', 'Gagal']);
    }
}
