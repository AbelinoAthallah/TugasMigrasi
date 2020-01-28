<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Buku_model;
use Auth;

class BukuController extends Controller
{
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'judul'=>'required',
            'penerbit'=>'required',
            'pengarang'=>'required',
            'foto'=>'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),
            400);
        }else{
            $insert=Buku_model::insert([
                'judul'=>$request->judul,
                'penerbit'=>$request->penerbit,
                'pengarang'=>$request->pengarang,
                'foto'=>$request->foto
            ]);
            if($insert){
                $status="sukses";
            }else{
                $status="gagal";
            }
            return response()->json(compact('status'));
        }
    }

    public function update($id,Request $req)
    {
        $validator=Validator::make($req->all(),
        [
            'judul'=>'required',
            'penerbit'=>'required',
            'pengarang'=>'required',
            'foto'=>'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $ubah=Buku_model::where('id', $id)->update([
            'judul'=>$req->judul,
            'penerbit'=>$req->penerbit,
            'pengarang'=>$req->pengarang,
            'foto'=>$req->foto
        ]);
        if($ubah){
            return Response()->json(['status'=>'Data berhasil diubah!']);
        }else{
            return Response()->json(['status'=>'Data gagal diubah!']);
        }
    }
    public function destroy($id)
    {
        $hapus=Buku_model::where('id',$id)->delete();
        if($hapus){
            return Response()->json(['status'=>'Data berhasil dihapus!']);
        }else{
            return Response()->json(['status'=>'Data gagal dihapus!']);
        }
    }


    public function tampil_buku()
    {
        if(Auth::User()->level=="admin"){
            $dt_buku=Buku_model::get();
            return response()->json($dt_buku);
        }else{
            return response()->json(['status'=>'anda bukan admin']);
        }
    }
}
