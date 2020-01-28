<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Anggota_model;
use Auth;

class AnggotaController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_anggota' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telp' => 'required|string|max:11',
            'username' => 'required|string|max:55',
            'password' => 'required|string|min:6|confirmed',
            'level' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = Anggota_model::create([
            'nama_anggota' => $request->get('nama_anggota'),
            'alamat' => $request->get('alamat'),
            'telp' => $request->get('telp'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
            'level' => $request->get('level'),
        ]);

        $token = JWTAuth::fromUser($user);

        $update = Anggota_model::where('nama_aggota', $request->nama_anggota)->update([
            'nama_aggota' => $request->get('nama_aggota'),
            'alamat' => $request->get('alamat'),
            'telp' => $request->get('telp'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
            'level' => $request->get('level'),
        ]);

        return response()->json(compact('user','token'),201);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'nama_anggota'=>'required',
            'alamat'=>'required',
            'telp'=>'required',
            'username'=>'required',
            'password'=>'required',
            'level'=>'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),
            400);
        }else{
            $insert=Anggota_model::insert([
                'nama_anggota'=>$request->nama_anggota,
                'alamat'=>$request->alamat,
                'telp'=>$request->telp,
                'username'=>$request->username,
                'password'=>$request->password,
                'level'=>$request->level
            ]);
            if($insert){
                $status="Sukses menambahkan data!";
            }else{
                $status="Gagal menambahkan data!";
            }
            return response()->json(compact('status'));
        }
    }

    public function update($id,Request $req)
    {
        $validator=Validator::make($req->all(),
        [
            'nama_anggota'=>'required',
            'alamat'=>'required',
            'telp'=>'required',
            'username'=>'required',
            'password'=>'required',
            'level'=>'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $ubah=Anggota_model::where('id', $id)->update([
            'nama_anggota'=>$req->nama_anggota,
            'alamat'=>$req->alamat,
            'telp'=>$req->telp,
            'username'=>$req->username,
            'password'=>$req->password,
            'level'=>$req->level
        ]);
        if($ubah){
            return Response()->json(['status'=>'Data berhasil diubah!']);
        }else{
            return Response()->json(['status'=>'Data gagal diubah!']);
        }
    }
    public function destroy($id)
    {
        $hapus=Anggota_model::where('id',$id)->delete();
        if($hapus){
            return Response()->json(['status'=>'Data berhasil dihapus!']);
        }else{
            return Response()->json(['status'=>'Data gagal dihapus!']);
        }
    }


    public function tampil_anggota()
    {
        if(Auth::User()->level=="admin"){
            $dt_anggota=Anggota_model::get();
            return response()->json($dt_anggota);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
}
