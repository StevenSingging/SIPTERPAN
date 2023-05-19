<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function postlogin (Request $request){
        //dd($request->all());
        $input=$request->all();
        if(auth()->attempt(array('username' => $input['username'], 'password' => $input['password']))){
            if(auth()->user()->role=='Mahasiswa'){
                return redirect('mahasiswa/dashboard');
            }else if(auth()->user()->role=='Dosen'){
                return redirect('dosen/dashboard');
            }else if(auth()->user()->role=='Admin'){
                return redirect('admin/dashboard');
            }
        }
        return redirect('/')->with('postlogin','Username atau Password Anda Salah, Silakan lakukan proses login kembali');
    }

    public function logout (Request $request){
        Auth::logout();
        return redirect('/')->with('logout','Anda berhasil logout');
    }
}
