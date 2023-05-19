<?php

namespace App\Http\Controllers;

use App\Charts\LogbookMhs;
use App\Models\Project;
use App\Models\Milestone;
use App\Models\Task;
use App\Models\User;
use App\Models\File;
use App\Models\Conversation;
use App\Models\Conversation_Replies;
use App\Models\Pterpan;
use App\Models\Notification;
use App\Models\Consultation;
use App\Models\Logbook;
use App\Models\History;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class MahasiswaController extends Controller
{
    public function index()
    {
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        //dd($leftmenu);
        $cprjct = Project::where(['mahasiswa1' => auth()->user()->no_induk], ['mahasiswa2' => auth()->user()->no_induk], ['mahasiswa3' => auth()->user()->no_induk])->count();
        $cprjcto = Project::where(['mahasiswa1' => auth()->user()->no_induk], ['mahasiswa2' => auth()->user()->no_induk], ['mahasiswa3' => auth()->user()->no_induk])->where('status', '0')->count();
        $cprjctd = Project::where(['mahasiswa1' => auth()->user()->no_induk], ['mahasiswa2' => auth()->user()->no_induk], ['mahasiswa3' => auth()->user()->no_induk])->where('status', '1')->count();
        $cprjctf = Project::where(['mahasiswa1' => auth()->user()->no_induk], ['mahasiswa2' => auth()->user()->no_induk], ['mahasiswa3' => auth()->user()->no_induk])->where('status', '2')->count();
        $history = History::pluck('no_induk')->unique();
        $pterpan = Pterpan::all();
        $project = DB::table('projects')
            ->where('mahasiswa1', auth()->user()->no_induk)
            ->orWhere(function ($query) {
                $query->where('mahasiswa2', auth()->user()->no_induk)
                    ->orWhere('mahasiswa3', auth()->user()->no_induk);
            })
            ->paginate();
        $projects = DB::table('projects')
            ->where('mahasiswa1', auth()->user()->no_induk)
            ->orWhere(function ($query) {
                $query->where('mahasiswa2', auth()->user()->no_induk)
                    ->orWhere('mahasiswa3', auth()->user()->no_induk);
            })
            ->get();
        // dd($cprjct);
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
        return view('mahasiswa.dashboard', compact('cprjct', 'leftmenu', 'history', 'pterpan', 'project', 'cprjcto', 'cprjctd', 'cprjctf'));
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
        return view('mahasiswa.timeline', compact('notif', 'leftmenu'));
    }

    public function project()
    {
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        // $project = Project::where(['mahasiswa1' => auth()->user()->no_induk , 'mahasiswa2' => auth()->user()->no_induk , 'mahasiswa2' => auth()->user()->no_induk])->paginate();
        $history = History::pluck('no_induk')->unique();
        $pterpan = Pterpan::all();
        $project = DB::table('projects')
            ->where('mahasiswa1', auth()->user()->no_induk)
            ->orWhere(function ($query) {
                $query->where('mahasiswa2', auth()->user()->no_induk)
                    ->orWhere('mahasiswa3', auth()->user()->no_induk);
            })
            ->paginate();
        return view('mahasiswa.project', compact('project', 'pterpan', 'leftmenu', 'history'));
    }

    public function viewproject($id, LogbookMhs $chart)
    {
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        $prjk = Project::where(['id' => $id])->get();
        $prjct = Project::where(['id' => $id])->first();
        $file = File::where(['project_id' => $id])->paginate();
        $history = History::pluck('no_induk')->unique();
        $pterpan = Pterpan::all();
        $milestonemhs = Milestone::where('project_id', $id)->get();
        $notifp = Notification::select('judul', 'user_id', 'project_id', 'created_at')
            ->where('project_id', $id)
            ->selectRaw('date(created_at) as tanggal')
            ->orderByDesc('tanggal')
            ->get()
            ->groupBy(function ($item) {
                return $item->tanggal;
            });
        $conver = Conversation::select('id', 'judul', 'user_id', 'teks', 'project_id', 'file_id', 'created_at')
            ->where(['project_id' => $id])
            ->groupBy('id', 'judul', 'user_id', 'teks', 'project_id', 'file_id', 'created_at')
            ->get();

        $converr = Conversation_Replies::select('conversation_id', 'user_id', 'teks', 'project_id', 'file_id', 'created_at')
            ->where(['project_id' => $id])
            ->groupBy('conversation_id', 'user_id', 'teks', 'project_id', 'file_id', 'created_at')
            ->orderBy('created_at', 'asc')
            ->get();

        $konsulmhs = Consultation::where('project_id', $id)->paginate();
        $kmhs = Consultation::where('project_id', $id)->first();
        $idArray = null;
        if (isset($kmhs) && !empty($kmhs)) {
            $idArray = json_decode($kmhs->mahasiswa);
            //lanjutan kode
        }
        $milestone = Milestone::where('project_id', $id)->get();
        foreach ($milestone as $mls) {
            if ($mls->jatuh_tempo < date('Y-m-d') && $mls->file_id == null) {
                $mls->status = '2';
                $mls->save();
            }
        }
        $logmhs = Logbook::where(['project_id' => $id, 'mahasiswa' => auth()->user()->no_induk])->paginate();
        $cmile = Milestone::where(['project_id' => $id])->count();
        $clog = Logbook::where('project_id', $id)
            ->whereIn('mahasiswa', function ($query) {
                $query->select('no_induk')
                    ->from('users')
                    ->where('no_induk', auth()->user()->no_induk);
            })
            ->count();
        //dd(date('d-m-Y'));
        return view('mahasiswa.vproject', compact('clog', 'cmile', 'history', 'logmhs', 'konsulmhs', 'idArray', 'prjk', 'prjct', 'pterpan', 'milestonemhs', 'notifp', 'conver', 'converr', 'file', 'leftmenu'), ['chart' => $chart->build($id)]);
    }

    public function calendar()
    {
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        $cmile = Milestone::whereHas('projectm', function ($query) {
            $query->where('mahasiswa1', auth()->user()->no_induk);
        })->orwhereHas('projectm', function ($query) {
            $query->where('mahasiswa2', '=', auth()->user()->no_induk);
        })->orwhereHas('projectm', function ($query) {
            $query->where('mahasiswa3', '=', auth()->user()->no_induk);
        })->get();
        $cproject = Project::where(['mahasiswa1' => auth()->user()->no_induk], ['mahasiswa2' => auth()->user()->no_induk], ['mahasiswa3' => auth()->user()->no_induk])->get();
        $events = array();
        foreach ($cproject as $cproject) {
            $events[] = [
                'title' => "Proyek {$cproject->nama}",
                'start' => $cproject->mulai,
                'end' => $cproject->jatuh_tempo,
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

        //dd($events);
        return view('mahasiswa.calendar', compact('events', 'leftmenu'));
    }

    public function tasklist()
    {
        $menu = new Project();
        $leftmenu = $menu->getmenu();
        $tasklist = Task::whereHas('projectt', function ($query) {
            $query->where('mahasiswa1', '=', auth()->user()->no_induk);
        })->orwhereHas('projectt', function ($query) {
            $query->where('mahasiswa2', '=', auth()->user()->no_induk);
        })->get();
        //dd($tasklist);
        return view('mahasiswa.tasklist', compact('tasklist', 'leftmenu'));
    }

    public function updatetask(Request $request, $id)
    {
        $request->validate([
            'filec' => 'required|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:2048'
        ]);
        $file = $request->file('filec');
        $filename = $file->getClientOriginalName();
        $path = $file->move(storage_path() . '\app\files', $filename);
        $task = Task::find($id);

        $filec = new File();
        $filec->project_id = $task->project_id;
        $filec->file_name = $filename;
        $filec->file_path = $path;
        $filec->save();

        $task->file_id = $filec->id;
        $task->user_id = $request->user()->id;
        $task->status = '1';
        $task->save();

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->project_id =  $task->project_id;
        $notif->judul = "Mengumpulkan Task " . $task->nama;
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();

        return redirect()->back();
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
        //dd($conr);
        return redirect()->back();
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

    public function simpanlogbook(Request $request)
    {

        $logbook = new Logbook();
        $logbook->project_id = $request->project_id;
        $logbook->mahasiswa = $request->user()->no_induk;
        $logbook->tgl_logbook = $request->tgl_logbook;
        $logbook->kegiatan = $request->kegiatan;
        $logbook->deskripsi = $request->deskripsi;
        $logbook->save();

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->project_id =  $request->project_id;
        $notif->judul = "Membuat Logbook " . $request->kegiatan;
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();

        // dd($checkbox);

        $sucess = array(
            'message' => 'Berhasil membuat Logbook',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function updatelogbook(Request $request, $id)
    {
        $logbook = Logbook::find($id);
        $logbook->tgl_logbook = $request->tgl_logbook;
        $logbook->kegiatan = $request->kegiatan;
        $logbook->deskripsi = $request->deskripsi;
        $logbook->save();

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->project_id =  $request->project_id;
        $notif->judul = "Mengupdate Logbook " . $request->kegiatan;
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();

        $sucess = array(
            'message' => 'Berhasil mengupdate Logbook',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function deletelogbook(Request $request, $id)
    {
        $logbook = Logbook::find($id);
        $logbook->delete();

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->project_id =  $request->project_id;
        $notif->judul = "Menghapus Logbook " . $request->kegiatan;
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();

        $sucess = array(
            'message' => 'Berhasil menghapus Logbook',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($sucess);
    }

    public function updatemilestone(Request $request, $id, $file_id = null)
    {
        $request->validate([
            'filec' => 'required|file|mimes:jpeg,png,jpg,pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:2048'
        ]);

        $file = File::find($file_id);

        $milestone = Milestone::find($id);

        if ($file) {
            // hapus file lama dari sistem file
            unlink($file->file_path);

            // proses file baru dan simpan di sistem file
            $newFile = $request->file('filec');
            $filename = $newFile->getClientOriginalName();
            $path = $newFile->move(storage_path() . '\app\files', $filename);

            // perbarui data file di tabel File dengan informasi file baru
            $file->project_id = $milestone->project_id;
            $file->file_name = $filename;
            $file->file_path = $path;
            $file->save();

            // perbarui file_id di tabel Milestone dengan id file baru
            $milestone->file_id = $file->id;
            $milestone->status = '1';
            $milestone->update();
        } else {
            $newFile = $request->file('filec');
            $filename = $newFile->getClientOriginalName();
            $path = $newFile->move(storage_path() . '\app\files', $filename);
            $milestone = Milestone::find($id);

            $filec = new File();
            $filec->project_id = $milestone->project_id;
            $filec->file_name = $filename;
            $filec->file_path = $path;
            $filec->save();

            $milestone->file_id = $filec->id;
            $milestone->status = '1';
            $milestone->update();
            //dd($filec);
        }

        $notif = new Notification();
        $notif->user_id = $request->user()->id;
        $notif->project_id =  $milestone->project_id;
        $notif->judul = "Mengumpulkan Milestone " . $milestone->nama;
        $notif->created_at = Carbon::now(); # new \Datetime()
        $notif->updated_at = Carbon::now(); # new \Datetime()
        $notif->save();

        $sucess = array(
            'message' => 'Berhasil mengumpulkan Milestone',
            'alert-type' => 'success'
        );
        //dd($notif);
        return redirect()->back()->with($sucess);
    }
}
