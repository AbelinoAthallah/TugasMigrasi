<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Peminjaman_model;
use App\Detail_model;
use Auth;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'tgl'=>'required',
            'id_anggota'=>'required',
            'id_petugas'=>'required',
            'deadline'=>'required'
            // 'denda'=>'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),
            400);
        }else{
            $insert=Peminjaman_model::insert([
                'tgl'=>$request->tgl,
                'id_anggota'=>$request->id_anggota,
                'id_petugas'=>$request->id_petugas,
                'deadline'=>$request->deadline
                // 'denda'=>$request->denda
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
            'tgl'=>'required',
            'id_anggota'=>'required',
            'id_petugas'=>'required',
            'deadline'=>'required'
            // 'denda'=>'required',
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $ubah=Peminjaman_model::where('id', $id)->update([
            'tgl'=>$request->tgl,
            'id_anggota'=>$request->id_anggota,
            'id_petugas'=>$request->id_petugas,
            'deadline'=>$request->deadline
            // 'denda'=>$request->denda
        ]);
        if($ubah){
            return Response()->json(['status'=>'Data berhasil diubah!']);
        }else{
            return Response()->json(['status'=>'Data gagal diubah!']);
        }
    }
    public function destroy($id)
    {
        $hapus=Peminjaman_model::where('id',$id)->delete();
        if($hapus){
            return Response()->json(['status'=>'Data berhasil dihapus!']);
        }else{
            return Response()->json(['status'=>'Data gagal dihapus!']);
        }
    }

    public function tampil_peminjaman($id)
    {
        $data_peminjaman=Peminjaman_model::join('anggota', 'anggota.id_anggota', 'peminjaman.id_anggota')->where('id',$id)->get();
        $arr_data=array();
        foreach ($data_peminjaman as $dt_peminjaman){
            $ok=Detail_model::where('id',$dt_peminjaman->id)->get();
            $arr_detail=array();
            foreach ($ok as $yes){
                $arr_detail[]=array(
                    'id'=>$yes->id,
                    'id_pinjam'=>$yes->id_pinjam,
                    'id_buku'=>$yes->id_pinjam,
                    'qty'=>$yes->qty
                );
            }
            $arr_data['Data']=array(
                'id_anggota'=>$dt_peminjaman->id_anggota,
                'nama_anggota'=>$dt_peminjaman->nama_anggota,
                'id_petugas'=>$dt_peminjaman->id_petugas,
                'tgl_pinjam'=>$dt_peminjaman->tgl,
                'tgl_deadline'=>$dt_peminjaman->deadline,
                'detail_buku'=>$arr_detail
            );
        }
        return Response()->json($arr_data);
    }

    //////////////////////////DETAIL PEMINJAMAN//////////////////////////

    public function store_detail(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'id_pinjam'=>'required',
            'id_buku'=>'required',
            'qty'=>'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),
            400);
        }else{
            $insert=Detail_model::insert([
                'id_pinjam'=>$request->id_pinjam,
                'id_buku'=>$request->id_buku,
                'qty'=>$request->qty
            ]);
            if($insert){
                $status="sukses";
            }else{
                $status="gagal";
            }
            return response()->json(compact('status'));
        }
    }

    public function update_detail($id,Request $req)
    {
        $validator=Validator::make($req->all(),
        [
            'id_pinjam'=>'required',
            'id_buku'=>'required',
            'qty'=>'required'
        ]);

        if($validator->fails()){
            return Response()->json($validator->errors());
        }
        $ubah=Detail_model::where('id', $id)->update([
            'id_pinjam'=>$request->id_pinjam,
            'id_buku'=>$request->id_buku,
            'qty'=>$request->qty
        ]);
        if($ubah){
            return Response()->json(['status'=>'Data berhasil diubah!']);
        }else{
            return Response()->json(['status'=>'Data gagal diubah!']);
        }
    }
    public function destroy_detail($id)
    {
        $hapus=Detail_model::where('id',$id)->delete();
        if($hapus){
            return Response()->json(['status'=>'Data berhasil dihapus!']);
        }else{
            return Response()->json(['status'=>'Data gagal dihapus!']);
        }
    }
}
