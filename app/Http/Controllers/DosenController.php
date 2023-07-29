<?php

namespace App\Http\Controllers;

use App\Charts\ConsultationDsn;
use App\Charts\MilestoneDsn;
use App\Models\Pterpan;
use App\Models\Project;
use App\Models\Task;
use App\Models\File;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Conversation_Replies;
use App\Models\Milestone;
use App\Models\Notification;
use App\Models\Consultation;
use App\Models\Logbook;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PDF;

class DosenController extends Controller
{
    public function index()
    {
        $menu = new Project();

        $leftmenu = $menu->getmenu();
        //dd($leftmenu);
        $cprjct = Project::where(['dosen' => auth()->user()->no_induk])->count();
        $cprjctf = Project::where(['dosen' => auth()->user()->no_induk, 'status' => '2'])->count();
        $cprjcts = Project::where(['dosen' => auth()->user()->no_induk, 'status' => '1'])->count();
        $cprjcto = Project::where(['dosen' => auth()->user()->no_induk, 'status' => '0'])->count();
        $projects = Project::where('dosen', auth()->user()->no_induk)->get();
        foreach ($projects as $p) {
            $nilaij = json_encode($p->nilai);
            $nim = Pterpan::select('no_induk')->get()->pluck('no_induk')->toArray();
    
            if (in_array($p->mahasiswa1, $nim) && isset($nilaij[0]) && $nilaij[0] < 55 && $p->jatuh_tempo < date('Y-m-d')) {
                $pterpans = Pterpan::where('no_induk', $p->mahasiswa1)->first();
                $pterpans->delete();
                
            } elseif (in_array($p->mahasiswa2, $nim) && isset($nilaij[1]) && $nilaij[1] < 55 && $p->jatuh_tempo < date('Y-m-d')) {
                $pterpans = Pterpan::where('no_induk', $p->mahasiswa2)->first();
                $pterpans->delete();
                
            } elseif (in_array($p->mahasiswa3, $nim) && isset($nilaij[2]) && $nilaij[2] < 55 && $p->jatuh_tempo < date('Y-m-d')) {
                $pterpans = Pterpan::where('no_induk', $p->mahasiswa3)->first();
                $pterpans->delete();
                
            }
        }
        foreach ($projects as $prj) {
            if ($prj->jatuh_tempo < date('Y-m-d')) {
                if ($prj->milestone()->where('status', 2)->exists()) {
                    $prj->status = '2';
                } else {
                    $prj->status = '1';
                }
                $prj->save();
            }
        }
        $project = Project::where(['dosen' => auth()->user()->no_induk])->paginate();
        $pterpan = Pterpan::all();
        $history = History::pluck('no_induk')->unique();
        return view('dosen.dashboard', compact('cprjct', 'leftmenu', 'cprjcts', 'cprjcto', 'cprjctf','project','pterpan','history'));
    }

    public function timeline()
    {
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        $notif = Notification::select('judul', 'user_id', 'created_at', 'project_id')
            ->where('user_id', auth()->user()->id)
            ->selectRaw('DATE(created_at) as tanggal, TIME(created_at) as waktu')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(function ($item) {
                return $item->tanggal;
            });
        //dd($notif);
        // return $notif->projectn()->first();
        return view('dosen.timeline', compact('notif', 'leftmenu'));
    }

    public function tasklist()
    {
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        $project = Project::all();
        //$tasklist = Task::where([$project->task()->dosen => auth()->user() -> no_induk],['project_id' => $project->id]);
        $tasklist = Task::whereHas('projectt', function ($query) {
            $query->where('dosen', '=', auth()->user()->no_induk);
        })->get();
        //dd($tasklist);
        return view('dosen.tasklist', compact('tasklist', 'leftmenu'));
    }

    public function project()
    {
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        $project = Project::where(['dosen' => auth()->user()->no_induk])->paginate();
        $pterpan = Pterpan::all();
        $history = History::pluck('no_induk')->unique();
        return view('dosen.projectdsn', compact('project', 'pterpan', 'leftmenu','history'));
    }

    public function viewproject(Request $request, $id, MilestoneDsn $chart,ConsultationDsn $chart1)
    {
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        $prjk = Project::where(['id' => $id])->get();
        $prjct = Project::where(['id' => $id])->first();
        $file = File::where(['project_id' => $id])->paginate();
        $cmiles = Milestone::where(['project_id' => $id])->count();
        $ckonsul = Consultation::where(['project_id' => $id])->count();
        $history = History::pluck('no_induk')->unique();
        $pterpan1 = Pterpan::all();
        $milestone = Milestone::all();
        $omiles = Milestone::where(['project_id' => $id])->get();
        $kdsn = Consultation::where(['project_id' => $id])->paginate();

        $notifp = Notification::select('judul', 'user_id', 'project_id', 'created_at')
            ->where('project_id', $id)
            ->selectRaw('DATE(created_at) as tanggal, TIME(created_at) as waktu')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy(function ($item) {
                return $item->tanggal;
            });
        $conver = Conversation::select('id', 'judul', 'user_id', 'teks', 'project_id', 'file_id','created_at')
            ->where(['project_id' => $id])
            ->groupBy('id', 'judul', 'user_id', 'teks', 'project_id', 'file_id','created_at')
            ->get();

        $converr = Conversation_Replies::select('conversation_id', 'user_id', 'teks', 'project_id', 'file_id', 'created_at')
            ->where(['project_id' => $id])
            ->groupBy('conversation_id', 'user_id', 'teks', 'project_id', 'file_id', 'created_at')
            ->orderBy('created_at', 'asc')
            ->get();

        $kkkdsn = Consultation::where('project_id', $id)->first();

        $logmhs = Logbook::where('project_id', $id)
            ->when($request->mahasiswa, function ($query) use ($request) {
                return $query->where('mahasiswa', '=', $request->mahasiswa);
            })->paginate();

           
        // dd($history);

        return view('dosen.vproject', compact('pterpan1','logmhs', 'kkkdsn', 'kdsn', 'prjk', 'prjct', 'history', 'cmiles', 'ckonsul', 'omiles', 'notifp',  'file', 'conver', 'converr', 'leftmenu'),['chart' => $chart->build($id),'chart1' => $chart1->build($id)]);
    }

    public function updatemilestone(Request $request, $id)
    {
        $project = Project::findOrFail($request->project_id);
        $request->validate([
            'mulaie' => 'required|date|after_or_equal:' . $project->mulai,
            'jatuh_tempoe' => 'required|date|before:' . $project->jatuh_tempo,
        ], [
            'mulaie.after_or_equal' => 'Tanggal tidak boleh kurang dari ' . $project->mulai,
            'jatuh_tempoe.before' => 'Tanggal tidak boleh lebih dari ' . $project->jatuh_tempo,
        ]);

        $milestone = Milestone::find($id);
        $milestone->nama = $request->nama;
        $milestone->deskripsi = $request->deskripsi;
        $milestone->mulai = $request->mulaie;
        $milestone->jatuh_tempo = $request->jatuh_tempoe;
        if ($milestone->status == '2') {
            $milestone->status = '0';
            $milestone->save();
        }
        $milestone->save();
        //dd($milestone);

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->project_id =  $request->project_id;
        $notif->judul = "Mengupdate Milestone " . $milestone->nama;
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();
        $sucess = array(
            'message' => 'Berhasil mengupdate Milestone',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess); 
    }

    public function simpanmilestone(Request $request)
    {
        $project = Project::findOrFail($request->project_id);
        $request->validate([
            'mulai' => 'required|date|after_or_equal:' . $project->mulai,
            'jatuh_tempo' => 'required|date|before:' . $project->jatuh_tempo,
        ], [
            'mulai.after_or_equal' => 'Tanggal tidak boleh kurang dari ' . $project->mulai,
            'jatuh_tempo.before' => 'Tanggal tidak boleh lebih dari ' . $project->jatuh_tempo,
        ]);
        //$project_id = Project::all();
        $nama = $request->nama;
        Milestone::create([
            'project_id' => $request->project_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'mulai' => $request->mulai,
            'jatuh_tempo' => $request->jatuh_tempo,
            'status' => '0'
        ]);

        Notification::create([
            'user_id' => $request->user()->id,
            'project_id' => $request->project_id,
            'judul' => "Membuat Milestone $nama ",
            'created_at' =>  Carbon::now(), # new \Datetime()
            'updated_at' => Carbon::now(),  # new \Datetime()
        ]);
        $sucess = array(
            'message' => 'Berhasil membuat Milestone',
            'alert-type' => 'success'
        );
        //dd($notip);
        return redirect()->back()->with($sucess);
    }

    public function deletemilestone(Request $request, $id)
    {
        $milestone = Milestone::find($id);
        $milestone->delete();

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->project_id =  $milestone->project_id;
        $notif->judul = "Menghapus Milestone " . $milestone->nama;
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();
        $sucess = array(
            'message' => 'Berhasil menghapus Milestone',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function simpankonsul(Request $request)
    {

        if (!empty($request->input('mahasiswa'))) {

            $konsul = new Consultation();
            $konsul->project_id = $request->project_id;
            $konsul->tgl_konsul = $request->tgl_konsul;
            $konsul->name = $request->name;
            $konsul->deskripsi = $request->deskripsi;
            $konsul->mahasiswa = json_encode($request->input('mahasiswa'));
            $konsul->save();

            $notif = new Notification();
            $notif->user_id = $request->user()->id;
            $notif->project_id =  $request->project_id;
            $notif->judul = "Membuat Konsultasi " . $request->name;
            $notif->mahasiswa =  json_encode($request->input('mahasiswa'));
            $notif->created_at = Carbon::now(); # new \Datetime()
            $notif->updated_at = Carbon::now(); # new \Datetime()
            $notif->save();
        } else {
            $checkbox = '';
        }
        // dd($checkbox);

        $sucess = array(
            'message' => 'Berhasil membuat Karu Konsul',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function updatekonsul(Request $request, $id)
    {

        $konsul = Consultation::find($id);
        $konsul->tgl_konsul = $request->tgl_konsul;
        $konsul->name = $request->name;
        $konsul->deskripsi = $request->deskripsi;
        $konsul->mahasiswa = json_encode($request->input('mahasiswa'));
        $konsul->save();
        //dd($milestone);

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->project_id =  $request->project_id;
        $notif->judul = "Mengupdate Konsultasi " . $request->name;
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();
        $sucess = array(
            'message' => 'Berhasil mengupdate Konsultasi',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function deletekonsul($id)
    {
        $konsul = Consultation::find($id);
        $konsul->delete();

        $notif = new Notification();
        $notif->user_id = auth()->user()->id;
        $notif->project_id =  $konsul->project_id;
        $notif->judul = "Menghapus Konsultasi " . $konsul->nama;
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();
        $sucess = array(
            'message' => 'Berhasil menghapus Konsultasi',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function updatetask(Request $request, $id)
    {
        $project = Project::find($id);
        $task = Task::find($id);
        $task->nama = $request->nama;
        $task->deskripsi = $request->deskripsi;
        $task->mulai = $request->mulai;
        $task->jatuh_tempo = $request->jatuh_tempo;
        $task->save();

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->project_id =  $request->project_id;
        $notif->judul = "Mengupdate Task " . $task->nama;
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();
        //dd($notif);
        $sucess = array(
            'message' => 'Berhasil mengupdate Task',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function deletetask(Request $request, $id)
    {
        $task = Task::find($id);
        $task->delete();

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->project_id =  $task->project_id;
        $notif->judul = "Menghapus Task " . $task->nama;
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();
        $sucess = array(
            'message' => 'Berhasil menghapus Task',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function calendar()
    {
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        $cmile = Milestone::whereHas('projectm', function ($query) {
            $query->where('dosen', '=', auth()->user()->no_induk);
        })->orwhereHas('projectm', function ($query) {
            $query->where('status', '=', '0');
        })->get();
        $cproject = Project::where(['dosen' => auth()->user()->no_induk], ['status' => '0'])->get();
        $eventsdsn = array();
        foreach ($cproject as $cproject) {
            $eventsdsn[] = [
                'title' => "Proyek {$cproject->nama}",
                'start' => $cproject->mulai,
                'end' => $cproject->jatuh_tempo,
                'color' => '#f56954',
            ];
        }
        foreach ($cmile as $cmile) {
            $eventsdsn[] = [
                'title' => "{$cmile->projectm->nama} | Milestones | {$cmile->nama}",
                'start' => $cmile->mulai,
                'end' => $cmile->jatuh_tempo,
                'color' => '#f39c12',
            ];
        }
        // dd($cpro);
        return view('dosen.calendar', compact('eventsdsn', 'leftmenu'));
    }

    public function simpanfile(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:2048'
        ]);

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $path = $file->move(storage_path() . '\app\files', $filename);

        File::create([
            'project_id' => $request->project_id,
            'file_name' => $filename,
            'file_path' => $path,

        ]);
        //dd($fileu);
        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->project_id = $request->project_id;
        $notif->judul = "Mengupload file " . $filename;
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();
        //dd($filename);
        $sucess = array(
            'message' => 'Berhasil menyimpan File',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function deletefile(Request $request, $id)
    {
        $file = File::find($id);
        $file->delete();

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->project_id = $file->project_id;
        $notif->judul = "Berhasil Menghapus File " . $file->file_name;
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();
        $sucess = array(
            'message' => 'Berhasil menghapus File',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function download($id)
    {

        // Get the file from the database using the id
        $file = File::find($id);
        $file_path = storage_path('app/files/' . $file->file_name);
        // Get the file path

        //dd($file_path);
        // Check if the file exists
        if (!File::exists($file->file_path)) {
            abort(404);
        }

        // Get the file content
        // $file_content = File::get($file_path);

        // Return the file as a response
        return response()->download($file->file_path);
    }

    public function simpanconversation(Request $request)
    {
        //dd($filec->id);
        $con = new Conversation();
        if (is_null($request->file('filec'))) {
            $con->project_id = $request->project_id;
            $con->judul = $request->judul;
            $con->user_id = $request->user()->id;
            $con->teks = $request->teks;
            $con->save();
        } else {
            $request->validate([
                'filec' => 'required|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:2048'
            ]);

            $file = $request->file('filec');
            $filename = $file->getClientOriginalName();
            $path = $file->move(storage_path() . '\app\files', $filename);
            //dd($request->all());
            $filec = new File();
            $filec->project_id = $request->project_id;
            $filec->file_name = $filename;
            $filec->file_path = $path;
            $filec->save();

            $con->project_id = $request->project_id;
            $con->judul = $request->judul;
            $con->user_id = $request->user()->id;
            $con->teks = $request->teks;
            $con->file_id = $filec->id;
            $con->save();
        }


        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->project_id = $request->project_id;
        $notif->judul = "Membuat Conversation " . $con->judul;
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();
        $sucess = array(
            'message' => 'Berhasil membuat Conversation',
            'alert-type' => 'success'
        );
        //dd($notif);
        return redirect()->back()->with($sucess);
    }

    public function simpanconversationreplies(Request $request)
    {

        $conr = new Conversation_Replies();
        if (is_null($request->file('filec'))) {
            $conr->conversation_id = $request->conver_id;
            $conr->project_id = $request->project_id;
            $conr->user_id = $request->user()->id;
            $conr->teks = $request->teks;
            $conr->save();
        } else {
            $request->validate([
                'filec' => 'required|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:2048'
            ]);

            $file = $request->file('filec');
            $filename = $file->getClientOriginalName();
            $path = $file->move(storage_path() . '\app\files', $filename);
            //dd($request->all());
            $filec = new File();
            $filec->project_id = $request->project_id;
            $filec->file_name = $filename;
            $filec->file_path = $path;
            $filec->save();

            $conr->conversation_id = $request->conver_id;
            $conr->project_id = $request->project_id;
            $conr->user_id = $request->user()->id;
            $conr->teks = $request->teks;
            $conr->file_id = $filec->id;
            $conr->save();
        }

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->project_id = $request->project_id;
        $notif->judul = "Membuat Conversation ";
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();
        //dd(Session::all());
        $sucess = array(
            'message' => 'Berhasil membuat ConversationReplies',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function nilai(Request $request)
    {
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        $pterpan = History::all();
        $project = Project::where('dosen', auth()->user()->no_induk)
        ->where('jatuh_tempo', '>', date('Y-m-d'))
        ->paginate();

        //dd($pterpans);
        return view('dosen.nilai', compact('leftmenu', 'project', 'pterpan'));
    }

    public function updatenilai(Request $request, $id)
    {
        $project = Project::find($id);
        $nilai = $request->input('nilai');
        $project->nilai = json_encode($nilai);
        $project->save();

        $nim = Pterpan::select('no_induk')->get()->pluck('no_induk')->toArray();

        if (in_array($project->mahasiswa1, $nim) && $request->input('nilai')[0] >= 55 && $project->jatuh_tempo < date('Y-m-d')) {
            $pterpan = Pterpan::where('no_induk', $project->mahasiswa1)->first();
            $pterpan->delete();
        } elseif (in_array($project->mahasiswa2, $nim) && $request->input('nilai')[1] >= 55 && $project->jatuh_tempo < date('Y-m-d')) {
            $pterpan = Pterpan::where('no_induk', $project->mahasiswa2)->first();
            $pterpan->delete();
        } elseif (in_array($project->mahasiswa3, $nim) && $request->input('nilai')[2] >= 55 && $project->jatuh_tempo < date('Y-m-d')) {
            $pterpan = Pterpan::where('no_induk', $project->mahasiswa3)->first();
            $pterpan->delete();
        }
        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->project_id =  $project->id;
        $notif->judul = "Menambah Nilai";
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();
        $sucess = array(
            'message' => 'Berhasil menambah nilai',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function downloadrekap($id)
    {
        $pterpan = Pterpan::all();
        $project = Project::where('id', $id)->get();
        $logbook = Logbook::where('project_id', $id)
            ->orderBy('mahasiswa', 'asc')
            ->paginate();
        $milestone = Milestone::where('project_id', $id)->paginate();
        $konsul = Consultation::where('project_id', $id)->paginate();
        $pdf = PDF::loadview('dosen.rekap', compact('project', 'pterpan', 'milestone', 'konsul', 'logbook'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Rekap.pdf');
    }
}
