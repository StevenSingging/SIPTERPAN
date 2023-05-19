<?php

namespace App\Http\Controllers;

use App\Models\Pterpan;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{

    public function autocomplete(Request $request)
    {
        try {
            $getFields = Pterpan::select('name', 'status')->where('no_induk', $request->get('no_induk'))->first();
            // here you could check for data and throw an exception if not found e.g.
            // if(!$getFields) {
            //     throw new \Exception('Data not found');
            // }
            return response()->json($getFields, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function simpanregistrasi(Request $request)
    {
        // dd($request->all());
        // $pterpan = Pterpan::select('status')->where('no_induk',$request->no_induk);
        $existingUser = User::where('no_induk', $request->no_induk)->orWhere('email', $request->email)->first();
        if ($existingUser) {
            return redirect('register')->with('fail','Data email atau no induk yang diinput sudah ada');
        } else {
            // Data no_induk belum ada, buat entri baru
            User::create([
                'username' => $request->username,
                'no_induk' => $request->no_induk,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'remember_token' => Str::random(60) 
            ]);

            return redirect('login')->with('regis','Berhasil registrasi');
        }
    }
}
