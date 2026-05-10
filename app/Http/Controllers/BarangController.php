<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(Request $r){
        if(!session('login')){
            return redirect('/login');
        }

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
        $gambar = null;
        
        if($r->hasFile('gambar')){
            $file = $r->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $gambar = 'images/products/' . $filename;
        }

        DB::table('barang')->insert([
            'nama_barang'=>$r->nama_barang,
            'kategori'=>$r->kategori,
            'harga_beli'=>$r->harga_beli,
            'harga_jual'=>$r->harga_jual,
            'stok'=>$r->stok,
            'satuan'=>$r->satuan,
            'gambar'=>$gambar
        ]);

        return redirect('/?pesan=berhasil');
    }

    public function edit($id){
        $row = DB::table('barang')->where('id_barang',$id)->first();
        return view('edit', compact('row'));
    }

    public function update(Request $r){
        $gambar = null;
        
        // Get existing image
        $existing = DB::table('barang')->where('id_barang',$r->id)->first();
        if($existing && $existing->gambar){
            $gambar = $existing->gambar;
        }
        
        // Handle new image upload
        if($r->hasFile('gambar')){
            // Delete old image if exists
            if($existing && $existing->gambar && file_exists(public_path($existing->gambar))){
                unlink(public_path($existing->gambar));
            }
            
            $file = $r->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $filename);
            $gambar = 'images/products/' . $filename;
        }

        DB::table('barang')->where('id_barang',$r->id)->update([
            'nama_barang'=>$r->nama_barang,
            'kategori'=>$r->kategori,
            'harga_beli'=>$r->harga_beli,
            'harga_jual'=>$r->harga_jual,
            'stok'=>$r->stok,
            'satuan'=>$r->satuan,
            'gambar'=>$gambar
        ]);

        return redirect('/?pesan=update');
    }

    public function delete($id){
        $barang = DB::table('barang')->where('id_barang',$id)->first();
        
        // Delete image if exists
        if($barang && $barang->gambar && file_exists(public_path($barang->gambar))){
            unlink(public_path($barang->gambar));
        }
        
        DB::table('barang')->where('id_barang',$id)->delete();
        return redirect('/?pesan=hapus');
    }
}