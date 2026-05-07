<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(Request $r){
        // if(!session('login')){
        //     return redirect('/login');
        // }

        if($r->cari){
            $data = DB::table('barang')
            ->where('nama_barang','like','%'.$r->cari.'%')->get();
        } else {
            $data = DB::table('barang')->get();
        }

        $total_barang = DB::table('barang')->count();
        $total_stok = DB::table('barang')->sum('stok');

        return view('index', compact('data','total_barang','total_stok'));
    }

    public function create(){
        return view('tambah');
    }

    public function store(Request $r){
        DB::table('barang')->insert([
            'nama_barang'=>$r->nama_barang,
            'kategori'=>$r->kategori,
            'harga_beli'=>$r->harga_beli,
            'harga_jual'=>$r->harga_jual,
            'stok'=>$r->stok,
            'satuan'=>$r->satuan
        ]);

        return redirect('/barang?pesan=berhasil');
    }

    public function edit($id){
        $row = DB::table('barang')->where('id_barang',$id)->first();
        return view('edit', compact('row'));
    }

    public function update(Request $r){
        DB::table('barang')->where('id_barang',$r->id)->update([
            'nama_barang'=>$r->nama_barang,
            'kategori'=>$r->kategori,
            'harga_beli'=>$r->harga_beli,
            'harga_jual'=>$r->harga_jual,
            'stok'=>$r->stok,
            'satuan'=>$r->satuan
        ]);

        return redirect('/barang?pesan=update');
    }

    public function delete($id){
        DB::table('barang')->where('id_barang',$id)->delete();
        return redirect('/?pesan=hapus');
    }
    public function apiBarang()
{
    $data = DB::table('barang')->get();

    return response()->json($data, 200, [], JSON_PRETTY_PRINT);
}

}