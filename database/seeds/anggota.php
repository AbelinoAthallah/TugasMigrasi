<?php

use Illuminate\Database\Seeder;

class anggota extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Anggota_model::insert([
        [
            'nama_anggota'=>'Fynas',
            'alamat'=>'jl jalan',
            'telp'=>'0812345678',
            'created_at'=> \Carbon\Carbon::now('Asia/Jakarta')
        ],
        [
            'nama_anggota'=>'Putra',
            'alamat'=>'jl jalan',
            'telp'=>'0812345678',
            'created_at'=> \Carbon\Carbon::now('Asia/Jakarta')
        ],
        [
            'nama_anggota'=>'Ansi',
            'alamat'=>'jl jalan',
            'telp'=>'0812345678',
            'created_at'=> \Carbon\Carbon::now('Asia/Jakarta')
        ],
        [
            'nama_anggota'=>'Malfynas',
            'alamat'=>'jl jalan',
            'telp'=>'0812345678',
            'created_at'=> \Carbon\Carbon::now('Asia/Jakarta')
        ],
        [
            'nama_anggota'=>'Malfy',
            'alamat'=>'jl jalan',
            'telp'=>'0812345678',
            'created_at'=> \Carbon\Carbon::now('Asia/Jakarta')
        ]

    ]);
    }
}
