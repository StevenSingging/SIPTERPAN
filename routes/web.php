<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use Symfony\Component\HttpFoundation\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
});

Route::get('/menu', function () {
    return view('template.sidebar');
});
//regis
Route::get('/autocomplete', '\App\Http\Controllers\RegisterController@autocomplete')->name('autocomplete');
Route::post('/simpanregistrasi', '\App\Http\Controllers\RegisterController@simpanregistrasi')->name('simpanregistrasi');
//login
Route::post('/postlogin','\App\Http\Controllers\LoginController@postlogin')->name('postlogin');
//logout
Route::get('/logout','\App\Http\Controllers\LoginController@logout')->name('logout');

//Dosen
Route::group(['middleware' => ['auth','cekrole:Dosen']],function(){
    //dashboard
    Route::get('dosen/dashboard', '\App\Http\Controllers\DosenController@index')->name('dosen');
    
    //notifikasi
    Route::get('dosen/timeline', '\App\Http\Controllers\DosenController@timeline')->name('timelinedsn');
    
    //calendar
    Route::get('dosen/calendar', '\App\Http\Controllers\DosenController@calendar')->name('calendardsn');
    
    //nilai
    Route::get('dosen/nilai', '\App\Http\Controllers\DosenController@nilai')->name('nilai');
    Route::post('dosen/updatenilai/{id}', '\App\Http\Controllers\DosenController@updatenilai')->name('updatenilai');
    
    //vproject
    Route::get('dosen/vprojectdsn/{id}', '\App\Http\Controllers\DosenController@viewproject')->name('viewprojectdsn');
    
    Route::post('dosen/simpanmilestone', '\App\Http\Controllers\DosenController@simpanmilestone')->name('simpanmilestone');
    Route::post('dosen/updatemilestone/{id}', '\App\Http\Controllers\DosenController@updatemilestone')->name('updatemilestone');
    Route::get('dosen/deletemilestone/{id}', '\App\Http\Controllers\DosenController@deletemilestone')->name('deletem');
    
    Route::post('dosen/simpankonsul', '\App\Http\Controllers\DosenController@simpankonsul')->name('simpankonsul');
    Route::post('dosen/updatekonsul/{id}', '\App\Http\Controllers\DosenController@updatekonsul')->name('updatekonsul');
    Route::get('dosen/deletekonsul/{id}', '\App\Http\Controllers\DosenController@deletekonsul')->name('deletekonsul');
    
    Route::post('dosen/simpanfile', '\App\Http\Controllers\DosenController@simpanfile')->name('simpanfile');
    Route::get('dosen/deletefile/{id}', '\App\Http\Controllers\DosenController@deletefile')->name('deletefile');
    
    Route::post('dosen/simpanconversation', '\App\Http\Controllers\DosenController@simpanconversation')->name('simpanconversdsn');
    Route::post('dosen/simpanconversationr', '\App\Http\Controllers\DosenController@simpanconversationreplies')->name('simpanconverreplydsn');
    
    Route::get('dosen/download/{id}', '\App\Http\Controllers\DosenController@download')->name('downloadfiledsn');
    Route::get('dosen/vprojectdsn/{id}/filterlogbook', '\App\Http\Controllers\DosenController@filterlogbook')->name('filterlogbook');
    Route::get('dosen/downloadrekap/{id}', '\App\Http\Controllers\DosenController@downloadrekap')->name('downloadrekap');
    
    // Route::get('dosen/tasklist', '\App\Http\Controllers\DosenController@tasklist')->name('tasklist');
    Route::get('dosen/project', '\App\Http\Controllers\DosenController@project')->name('projectdsn');
    // Route::put('/milestone/{id}/update-status', '\App\Http\Controllers\DosenController@updateMilestoneStatus')->name('milestone.update-status');
});

//Mahasiswa
Route::group(['middleware' => ['auth','cekrole:Mahasiswa']],function(){
    //dashboard
    Route::get('mahasiswa/dashboard', '\App\Http\Controllers\MahasiswaController@index')->name('mahasiswa');
    //notifikasi
    Route::get('mahasiswa/timeline', '\App\Http\Controllers\MahasiswaController@timeline')->name('timelinemhs');
    //calendar
    Route::get('mahasiswa/calendar', '\App\Http\Controllers\MahasiswaController@calendar')->name('calendarmhs');
    //vproject
    Route::get('mahasiswa/vproject/{id}', '\App\Http\Controllers\MahasiswaController@viewproject')->name('viewproject');
    // Route::get('mahasiswa/vproject/{id}/milestone', '\App\Http\Controllers\MahasiswaController@viewproject')->name('viewproject');
    // Route::get('mahasiswa/tasklist', '\App\Http\Controllers\MahasiswaController@tasklist')->name('tasklistmhs');
    Route::post('mahasiswa/simpanconversation', '\App\Http\Controllers\MahasiswaController@simpanconversation')->name('simpanconvers');
    Route::post('mahasiswa/simpanconversationr', '\App\Http\Controllers\MahasiswaController@simpanconversationreplies')->name('simpanconverreply');
    Route::get('mahasiswa/download/{id}', '\App\Http\Controllers\MahasiswaController@download')->name('downloadfile');
    Route::post('mahasiswa/simpanlogbook', '\App\Http\Controllers\MahasiswaController@simpanlogbook')->name('simpanlogbook');
    Route::post('mahasiswa/updatelogbook/{id}', '\App\Http\Controllers\MahasiswaController@updatelogbook')->name('updatelogbook');
    Route::get('mahasiswa/deletelogbook/{id}', '\App\Http\Controllers\MahasiswaController@deletelogbook')->name('deletelogbook');
    Route::post('mahasiswa/updatemilestone/{id}/{file_id?}', '\App\Http\Controllers\MahasiswaController@updatemilestone')->name('updatemilestone');
    Route::get('mahasiswa/project', '\App\Http\Controllers\MahasiswaController@project')->name('projectmhs');


});

//Admin
Route::group(['middleware' => ['auth','cekrole:Admin']],function(){
    //dashboard
    Route::get('admin/dashboard', '\App\Http\Controllers\AdminController@index')->name('admin');
    //notifikasi
    Route::get('admin/timeline', '\App\Http\Controllers\AdminController@timeline')->name('timelineadm');
    //calendar
    Route::get('admin/calendar', '\App\Http\Controllers\AdminController@calendar')->name('calendar');
    //mahasiswa
    Route::get('admin/mahasiswa', '\App\Http\Controllers\AdminController@mahasiswa')->name('mhs');
    Route::post('admin/simpanmhs', '\App\Http\Controllers\AdminController@simpanmhs')->name('simpanmhs');
    Route::post('users-import', '\App\Http\Controllers\AdminController@import')->name('mahasiswa.import');
    Route::get('showproject/{nim}', '\App\Http\Controllers\AdminController@showProjectsByNim')->name('showproject');
    Route::get('jumlah_project/{nim}', '\App\Http\Controllers\AdminController@getJumlahProjectByNim')->name('jumlahproject');
    Route::get('admin/deletemhs/{id}', '\App\Http\Controllers\AdminController@deletemhs')->name('deletemhs');
    Route::post('admin/updatemhs/{id}', '\App\Http\Controllers\AdminController@updatemhs')->name('updatemhs');

    //dosen
    Route::get('admin/dosen', '\App\Http\Controllers\AdminController@dosen')->name('dsn');
    Route::post('admin/simpandsn', '\App\Http\Controllers\AdminController@simpandsn')->name('simpandsn');
    Route::get('admin/deletedsn/{id}', '\App\Http\Controllers\AdminController@deletedsn')->name('deletedsn');
    Route::post('admin/updatedsn/{id}', '\App\Http\Controllers\AdminController@updatedsn')->name('updatedsn');

    
    //listproject
    Route::get('admin/listproject', '\App\Http\Controllers\AdminController@listproject')->name('listp');
    Route::post('admin/updateproject/{id}', '\App\Http\Controllers\AdminController@updateproject')->name('updateproject');

    //tambah project
    Route::get('admin/tambahproject', '\App\Http\Controllers\AdminController@tambahproject')->name('tmbhprjk');
    Route::post('admin/simpanproject', '\App\Http\Controllers\AdminController@simpanproject')->name('simpanproject');

    //listperiode
    Route::get('admin/listperiode', '\App\Http\Controllers\AdminController@listperiode')->name('listperiode');
    Route::post('admin/simpanperiode', '\App\Http\Controllers\AdminController@tambahperiode')->name('tambahperiode');
    Route::post('admin/updatedataperiode/{id}', '\App\Http\Controllers\AdminController@updatedataperiode')->name('updatedataperiode');
    Route::post('admin/updateperiode/{id}', '\App\Http\Controllers\AdminController@updateperiode')->name('updateperiode');

    //history
    Route::get('admin/history', '\App\Http\Controllers\AdminController@history')->name('history');

    Route::get('admin/vprojectadm/{id}', '\App\Http\Controllers\AdminController@viewproject')->name('viewprojectadm');


});
