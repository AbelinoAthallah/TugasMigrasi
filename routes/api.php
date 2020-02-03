<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

Route::post('register_anggota', 'AnggotaController@register');
Route::post('login', 'AnggotaController@login');

Route::get('/',function(){
    return Auth::user()->level;
})->middleware('jwt.verify');

/////////////////////////////////////PETUGAS
Route::post('/simpan_petugas', 'UserController@store')->middleware('jwt.verify');
Route::put('/ubah_petugas/{id}','UserController@update')->middleware('jwt.verify');
Route::delete('/hapus_petugas/{id}','UserController@destroy')->middleware('jwt.verify');
Route::get('/tampil_petugas','UserController@tampil_petugas')->middleware('jwt.verify');

/////////////////////////////////////BUKU
Route::post('/simpan_buku', 'BukuController@store')->middleware('jwt.verify');
Route::put('/ubah_buku/{id}','BukuController@update')->middleware('jwt.verify');
Route::delete('/hapus_buku/{id}','BukuController@destroy')->middleware('jwt.verify');
Route::get('/tampil_buku','BukuController@tampil_buku')->middleware('jwt.verify');

/////////////////////////////////////ANGGOTA
Route::post('/simpan_anggota', 'AnggotaController@store')->middleware('jwt.verify');
Route::put('/ubah_anggota/{id}','AnggotaController@update')->middleware('jwt.verify');
Route::delete('/hapus_anggota/{id}','AnggotaController@destroy')->middleware('jwt.verify');
Route::get('/tampil_anggota','AnggotaController@tampil_anggota')->middleware('jwt.verify');

/////////////////////////////////////PEMINJAMAN
Route::post('/simpan_peminjaman', 'PeminjamanController@store')->middleware('jwt.verify');
Route::put('/ubah_peminjaman/{id}','PeminjamanController@update')->middleware('jwt.verify');
Route::delete('/hapus_peminjaman/{id}','PeminjamanController@destroy')->middleware('jwt.verify');
Route::get('/tampil_peminjaman/{id}','PeminjamanController@tampil_peminjaman')->middleware('jwt.verify');

/////////////////////////////////////DETAIL
Route::post('/simpan_detail', 'PeminjamanController@store_detail')->middleware('jwt.verify');
Route::put('/ubah_detail/{id}','PeminjamanController@update_detail')->middleware('jwt.verify');
Route::delete('/hapus_detail/{id}','PeminjamanController@destroy_detail')->middleware('jwt.verify');
Route::get('/tampil_detail','PeminjamanController@tampil_peminjaman')->middleware('jwt.verify');


