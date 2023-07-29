<?php

namespace App\Http\Controllers;

use App\Charts\TotalValueChart;
use App\Charts\YearParticipantChart;
use App\Charts\YearProjectChart;
use App\Models\User;
use App\Models\Pterpan;
use App\Models\Task;
use App\Models\Notification;
use App\Models\Milestone;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Fragment\FragmentHandler;
use Illuminate\Support\Facades\Validator;
use App\Models\File;
use App\Models\Conversation;
use App\Models\Conversation_Replies;
use App\Models\Periode;
use App\Models\History;
use App\Imports\PterpanImport;
use Maatwebsite\Excel\Facades\Excel;


class AdminController extends Controller
{
    public function index(YearProjectChart $chart, YearParticipantChart $chart1)
    {
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        //dd($leftmenu);
        $totalproject = Project::all()->count();
        $totaluser = User::all()->count();
        $totalmhs = Pterpan::where('status', 'Mahasiswa')->count();
        $totaldsn = Pterpan::where('status', 'Dosen')->count();
        $data['YearProjectChart'] = $chart->build();
        return view('admin.dashboard', compact('leftmenu', 'totalproject', 'totaluser', 'totalmhs', 'totaldsn'), ['chart' => $chart->build(), 'chart1' => $chart1->build()]);
    }
    public function timeline()
    {
        $menu = new Project();

        $leftmenu = $menu->getmenu();
        $notif = Notification::select('judul', 'user_id', 'created_at')
            ->where('user_id', auth()->user()->id)
            ->selectRaw('DATE(created_at) as tanggal, TIME(created_at) as waktu')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(function ($item) {
                return $item->tanggal;
            });
        //dd($notif);

        return view('admin.timeline', compact('notif', 'leftmenu'));
    }
    public function calendar()
    {
        $cmile = Milestone::all();
        $calendar = Project::all();
        $events = array();
        $menu = new Project();

        $leftmenu = $menu->getmenu();
        foreach ($calendar as $calendar) {
            $events[] = [
                'title' => "Proyek {$calendar->nama}",
                'start' => $calendar->mulai,
                'end' => $calendar->jatuh_tempo,
                'color' => '#f56954',
            ];
        }
        foreach ($cmile as $cmile) {
            $events[] = [
                'title' => "{$cmile->projectm->nama} | Milestones | {$cmile->nama}",
                'start' => $cmile->mulai,
                'end' => $cmile->jatuh_tempo,
                'color' => '#f39c12',
            ];
        }
        //dd($ctask);
        return view('admin.calendar', compact('events', 'leftmenu'));
    }

    public function dosen()
    {
        $menu = new Project();

        $leftmenu = $menu->getmenu();
        $dsn = Pterpan::where('status', 'Dosen')
            ->orderBy('no_induk', 'asc')
            ->paginate();
        return view('admin.tambahdsn', compact('dsn', 'leftmenu'));
    }

    public function tambahproject()
    {
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        $mhs = Pterpan::where('status', 'Mahasiswa')->get();
        $dsn = Pterpan::where('status', 'Dosen')->get();
        $periode = Periode::where('status', '1')->first();
        return view('admin.tambahprjk', compact('dsn', 'mhs', 'leftmenu', 'periode'));
    }

    public function simpanproject(Request $request)
    {
        // dd($request->all());
        $nama = $request->nama;
        $periode = Periode::where('status', '1')->first();
        Project::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'mulai' => $request->mulai,
            'jatuh_tempo' => $request->jatuh_tempo,
            'dosen' => $request->dosen,
            'mahasiswa1' => $request->mahasiswa1,
            'mahasiswa2' => $request->mahasiswa2,
            'mahasiswa3' => $request->mahasiswa3,
            'tahun_ajaran' => $periode->tahun_ajaran,
            'status' => '0'
        ]);
        // dd($project);
        Notification::create([
            'user_id' => $request->user()->id,
            'judul' => "Membuat Project $nama ",
            "created_at" =>  Carbon::now(), # new \Datetime()
            "updated_at" => Carbon::now(),  # new \Datetime()
        ]);
        $sucess = array(
            'message' => 'Berhasil membuat Project',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function simpanmhs(Request $request)
    {
        $periode = Periode::where('status', '1')->first();
        Pterpan::create([
            'no_induk' => $request->nim,
            'name' => $request->name,
            'pengambilan' => '1',
            'tahun_ajaran' => $periode->tahun_ajaran,
            'status' => 'Mahasiswa'
        ]);
        History::firstOrCreate(
            ['no_induk' => $request->nim, 'tahun_ajaran' => $periode->tahun_ajaran],
            ['nama' =>  $request->name]
        );

        Notification::create([
            'user_id' => $request->user()->id,
            'judul' => "Menambah Mahasiswa ",
            "created_at" =>  Carbon::now(), # new \Datetime()
            "updated_at" => Carbon::now(),  # new \Datetime()
        ]);
        $sucess = array(
            'message' => 'Berhasil menambah Mahasiswa',
            'alert-type' => 'success'
        );
        return redirect('admin/mahasiswa')->with($sucess);
    }

    public function mahasiswa()
    {
        $menu = new Project();

        $leftmenu = $menu->getmenu();
        $mhs = Pterpan::where('status', 'Mahasiswa')
            ->orderBy('no_induk', 'asc')
            ->paginate(500);
        $projects = Project::all();
        foreach ($projects as $p) {
            $nilaij = json_encode($p->nilai);
            $nim = Pterpan::select('no_induk')->get()->pluck('no_induk')->toArray();

            if (in_array($p->mahasiswa1, $nim) && isset($nilaij[0]) && $nilaij[0] >= 55 && $p->jatuh_tempo < date('Y-m-d')) {
                $pterpans = Pterpan::where('no_induk', $p->mahasiswa1)->first();
                $pterpans->delete();
            } elseif (in_array($p->mahasiswa2, $nim) && isset($nilaij[1]) && $nilaij[1] >= 55 && $p->jatuh_tempo < date('Y-m-d')) {
                $pterpans = Pterpan::where('no_induk', $p->mahasiswa2)->first();
                $pterpans->delete();
            } elseif (in_array($p->mahasiswa3, $nim) && isset($nilaij[2]) && $nilaij[2] >= 55 && $p->jatuh_tempo < date('Y-m-d')) {
                $pterpans = Pterpan::where('no_induk', $p->mahasiswa3)->first();
                $pterpans->delete();
            }
        }
        return view('admin.tambahmhs', compact('mhs', 'leftmenu'));
    }

    public function updatemhs(Request $request, $id)
    {
        $mhs = Pterpan::find($id);
        $mhs->name = $request->name;
        $mhs->no_induk = $request->no_induk;
        $mhs->save();

        $mhsh = History::where('no_induk',$request->no_induk)->first();
        if ($mhsh) {
            $mhsh->nama = $request->name;
            $mhsh->no_induk = $request->no_induk;
            $mhsh->save();
        }

        $mhsu = User::where('no_induk',$request->no_induk)->first();
        if ($mhsu) {
            $mhsu->name = $request->name;
            $mhsu->no_induk = $request->no_induk;
            $mhsu->save();
        }


        $sucess = array(
            'message' => 'Berhasil mengupdate Mahasiswa',
            'alert-type' => 'success'
        );
        // Set status periode lain menjadi tidak aktif jika ada satu periode yang diaktifkan

        return redirect()->back()->with($sucess);
    }

    public function updatedsn(Request $request, $id)
    {
        $dsn = Pterpan::find($id);
        $dsn->name = $request->name;
        $dsn->no_induk = $request->no_induk;
        $dsn->save();

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->judul = "Mengupdate Dosen";
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();

        $sucess = array(
            'message' => 'Berhasil mengupdate Dosen',
            'alert-type' => 'success'
        );
        // Set status periode lain menjadi tidak aktif jika ada satu periode yang diaktifkan

        return redirect()->back()->with($sucess);
    }

    public function simpandsn(Request $request)
    {
        Pterpan::create([
            'no_induk' => $request->nidn,
            'name' => $request->name,
            'status' => 'Dosen'
        ]);

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->judul = "Menambah Dosen";
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();

        $sucess = array(
            'message' => 'Berhasil menambah Dosen',
            'alert-type' => 'success'
        );
        return redirect('admin/dosen')->with($sucess);
    }

    public function viewproject($id)
    {
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        $prjk = Project::where(['id' => $id])->get();
        $file = File::where(['project_id' => $id])->paginate();
        $cdsn = Project::where(['id' => $id])->whereNotNull('dosen')->count();
        $cmhs1 = Project::where(['id' => $id])->whereNotNull('mahasiswa1')->count();
        $cmhs2 = Project::where(['id' => $id])->whereNotNull('mahasiswa2')->count();
        $history = History::pluck('no_induk')->unique();
        $pterpan1 = Pterpan::all();
        $milestone = Milestone::all();
        $omiles = Milestone::where(['project_id' => $id])->get();
        $otask = Task::where(['project_id' => $id])->get();
        $notifp = Notification::select('judul', 'user_id', 'project_id', 'created_at')
            ->where('project_id', $id)
            ->selectRaw('date(created_at) as tanggal')
            ->orderByDesc('tanggal', 'created_at')
            ->get()
            ->groupBy(function ($item) {
                return $item->tanggal;
            });
        $conver = Conversation::select('id', 'judul', 'user_id', 'teks', 'project_id', 'file_id')
            ->where(['project_id' => $id])
            ->groupBy('id', 'judul', 'user_id', 'teks', 'project_id', 'file_id')
            ->get();

        $converr = Conversation_Replies::select('conversation_id', 'user_id', 'teks', 'project_id', 'file_id', 'created_at')
            ->where(['project_id' => $id])
            ->groupBy('conversation_id', 'user_id', 'teks', 'project_id', 'file_id', 'created_at')
            ->orderBy('created_at', 'asc')
            ->get();
        //dd($cmile);
        return view('admin.vprojectadm', compact('prjk', 'history', 'pterpan1', 'cdsn', 'cmhs1', 'cmhs2', 'omiles', 'notifp', 'otask', 'file', 'conver', 'converr', 'leftmenu'));
    }

    public function getJumlahProjectByNim($nim)
    {
        $jumlah_project = DB::table('projects')
            ->where('mahasiswa1', $nim)
            ->orWhere('mahasiswa2', $nim)
            ->orWhere('mahasiswa3', $nim)
            ->count();

        return response()->json(['jumlah_project' => $jumlah_project]);
    }

    public function showProjectsByNim($nim)
    {
        $projects = Project::where('mahasiswa1', $nim)
            ->orWhere('mahasiswa2', $nim)
            ->orWhere('mahasiswa3', $nim)
            ->leftJoin('pterpans', 'projects.dosen', '=', 'pterpans.no_induk')
            ->select('projects.*', 'pterpans.name as dosen')
            ->get();

        $nilai = [];
        foreach ($projects as $project) {
            $dosen = $project->dosen;
            $dosens[] = $dosen;
            $nilai[] = json_decode($project->nilai, true)[array_search($nim, [$project->mahasiswa1, $project->mahasiswa2, $project->mahasiswa3])];
        }

        return response()->json(['projects' => $projects, 'nilai' => $nilai, 'dosens' => $dosens]);
    }

    public function listproject(Request $request)
    {
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        $project = Project::all();
        $semester = $request->semester;
        $tahun_ajaran = $request->tahun_ajaran;
        $mhs = Pterpan::where('status', 'Mahasiswa')->get();
        $listproject = Project::when($tahun_ajaran, function ($query) use ($tahun_ajaran) {
            return $query->where('tahun_ajaran', '=', $tahun_ajaran);
        })->paginate();
        $tahunajaran = $project->unique('tahun_ajaran')->pluck('tahun_ajaran');
        $dsn = Pterpan::where('status', 'Dosen')->get();

        return view('admin.listproject', compact('leftmenu', 'project', 'tahunajaran', 'listproject', 'mhs', 'dsn'));
    }

    public function listperiode()
    {
        $periode = Periode::paginate();
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        $lastPeriode = Periode::orderBy('tahun_ajaran', 'desc')->first();

        if ($lastPeriode) {
            // Mendapatkan nilai tahun ajaran terakhir
            $lastTahunAjaran = $lastPeriode->tahun_ajaran;
        
            // Mendapatkan dua digit terakhir tahun ajaran terakhir
            $lastTahunAjaranDigit = intval(substr($lastTahunAjaran, -2));
        
            // Menentukan dua digit terakhir yang baru
            if ($lastTahunAjaranDigit % 10 === 2) {
                // Jika dua digit terakhir adalah 2, maka ganti menjadi 1
                $newTahunAjaranDigit = 1;
                
                // Mendapatkan tahun ajaran dengan format YYYY
                $tahunAjaranYYYY = substr($lastTahunAjaran, 0, 4) + 1;
            } else {
                // Menggunakan dua digit terakhir yang sama dengan tahun ajaran terakhir
                $newTahunAjaranDigit = $lastTahunAjaranDigit + 1;
                
                // Mendapatkan tahun ajaran dengan format YYYY
                $tahunAjaranYYYY = intval(substr($lastTahunAjaran, 0, -2));
            }
        
            // Menggabungkan dua digit terakhir yang baru dengan tahun ajaran YYYY
            $newTahunAjaran = $tahunAjaranYYYY . sprintf("%01d", $newTahunAjaranDigit);
        
            // Menggunakan nilai tahun ajaran baru untuk menampilkan pada form
            $tahunAjaranDefault = $newTahunAjaran;
        }
        return view('admin.listperiode', compact('periode', 'leftmenu','tahunAjaranDefault'));
    }

    public function tambahperiode(Request $request)
    {
        $periode = new Periode();
        $periode->tahun_ajaran = $request->tahun_ajaran;
        $periode->tgl_awal = $request->tgl_awal;
        $periode->tgl_akhir = $request->tgl_akhir;
        $periode->save();

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->judul = "Menambah Periode";
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();

        $sucess = array(
            'message' => 'Berhasil membuat Periode',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function updateperiode(Request $request, $id)
    {
        $periode = Periode::findorFail($id);

        $periode->status = $request->status;
        $periode->save();
        // Set status periode lain menjadi tidak aktif jika ada satu periode yang diaktifkan
        if ($request->status == 1) {
            Periode::where('id', '!=', $periode->id)->update(['status' => '0']);
        }

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->judul = "Mengganti Periode";
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();

        $sucess = array(
            'message' => 'Berhasil merubah Periode',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function updatedataperiode(Request $request, $id)
    {
        $periode = Periode::find($id);

        $periode->tahun_ajaran = $request->tahun_ajaran;
        $periode->tgl_awal = $request->tgl_awal;
        $periode->tgl_akhir = $request->tgl_akhir;
        $periode->save();
        $sucess = array(
            'message' => 'Berhasil mengupdate Periode',
            'alert-type' => 'success'
        );
        // Set status periode lain menjadi tidak aktif jika ada satu periode yang diaktifkan

        return redirect()->back()->with($sucess);
    }

    public function updateproject(Request $request, $id)
    {
        $project = Project::find($id);
        $project->nama = $request->nama;
        $project->deskripsi = $request->deskripsi;
        $project->dosen = $request->dosen;
        $project->mahasiswa1 = $request->mahasiswa1;
        $project->mahasiswa2 = $request->mahasiswa2;
        $project->mahasiswa3 = $request->mahasiswa3;
        $project->save();

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->judul = "Mengupdate Proyek";
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();

        $sucess = array(
            'message' => 'Berhasil mengupdate Proyek',
            'alert-type' => 'success'
        );
        // Set status periode lain menjadi tidak aktif jika ada satu periode yang diaktifkan

        return redirect()->back()->with($sucess);
    }


    public function import()
    {
        Excel::import(new PterpanImport, request()->file('file'));

        $notif = new Notification();
        $notif->user_id = auth()->user()->id;
        $notif->judul = "Mengimport Data Mahasiswa";
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();

        $sucess = array(
            'message' => 'Berhasil mengimport data mahasiswa',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function deletemhs(Request $request, $id)
    {
        $mhs = Pterpan::find($id);
        $mhs->delete();

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->judul = "Menghapus Mahasiswa";
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();

        $sucess = array(
            'message' => 'Berhasil menghapus Mahasiswa',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function deletedsn(Request $request, $id)
    {
        $mhs = Pterpan::find($id);
        $mhs->delete();

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->judul = "Menghapus Dosen";
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();

        $sucess = array(
            'message' => 'Berhasil menghapus Dosen',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function history()
    {
        $history = History::select('tahun_ajaran', DB::raw('count(*) as jumlah_mahasiswa'))
            ->groupBy('tahun_ajaran')
            ->paginate(10);
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        return view('admin.history', compact('history', 'leftmenu'));
    }
}
