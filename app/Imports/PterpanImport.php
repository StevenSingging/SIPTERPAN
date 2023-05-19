<?php

namespace App\Imports;

use App\Models\Pterpan;
use App\Models\Periode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Project;
use App\Models\History;
use Hash;

class PterpanImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $periode = Periode::where('status', '1')->first();
        $pterpanQuery = Pterpan::where('no_induk', $row['no_induk']);
        $pterpan = $pterpanQuery->first();
        $nim = $row['no_induk'];
        $tahun_ajaran = $periode->tahun_ajaran;
        if ($pterpanQuery->exists()) {
            $projects = Project::where(function ($query) use ($nim) {
                $query->where('mahasiswa1', $nim)
                    ->orWhere('mahasiswa2', $nim)
                    ->orWhere('mahasiswa3', $nim);
            })->get();
            $count = 0;
            foreach ($projects as $project) {
                if($project->nilai != null){
                    $nilai = json_decode($project->nilai, true);
                    if ($project->mahasiswa1 == $nim && $nilai[0] <= 55) {
                        $count++;
                    } elseif ($project->mahasiswa2 == $nim && $nilai[1] <= 55) {
                        $count++;
                    } elseif ($project->mahasiswa3 == $nim && $nilai[2] <= 55) {
                        $count++;
                    }
                }
            }
            if ($count > 0) {
                $pterpan->increment('pengambilan', $count);
                $pterpan->tahun_ajaran = $tahun_ajaran;
                $pterpan->save();
            }
        } else {
            $pterpan = new Pterpan([
                'no_induk'     => $row['no_induk'],
                'name'    => $row['name'],
                'status' => $row['status'],
                'tahun_ajaran' => $periode->tahun_ajaran,
                'pengambilan' => '1',
            ]);
            $pterpan->save(); // menyimpan data ke dalam database
        }

        $pterpan = History::firstOrCreate(
            ['no_induk' => $nim, 'tahun_ajaran' => $tahun_ajaran],
            ['nama' => $row['name']]
        );
        $pterpan->save();

        return $pterpan;
    }
}
