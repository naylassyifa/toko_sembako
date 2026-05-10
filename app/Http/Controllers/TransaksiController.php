<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $barang = DB::table('barang')->get();

        $keranjang = session('cart', []);

        $total = 0;

        foreach ($keranjang as $item) {

            $subtotal = $item['harga'] * $item['qty'];

            $total += $subtotal;
        }

        return view('transaksi', compact(
            'barang',
            'keranjang',
            'total'
        ));
    }

    public function tambahKeranjang($id)
    {
        $barang = DB::table('barang')
                    ->where('id_barang', $id)
                    ->first();

        // Cek stok
        if(!$barang || $barang->stok <= 0) {
            return redirect('/transaksi')->with('error', 'Stok barang tidak tersedia');
        }

        $keranjang = session()->get('cart', []);

        if(isset($keranjang[$id])){
            // Cek apakah qty sudah melebihi stok
            if($keranjang[$id]['qty'] >= $barang->stok) {
                return redirect('/transaksi')->with('error', 'Qty melebihi stok yang tersedia untuk ' . $barang->nama_barang);
            }
            $keranjang[$id]['qty']++;

        } else {

            $keranjang[$id] = [
                "id" => $barang->id_barang,
                "nama" => $barang->nama_barang,
                "harga" => $barang->harga_jual,
                "qty" => 1,
                "stok_available" => $barang->stok
            ];
        }

        session()->put('cart', $keranjang);

        return redirect('/transaksi')->with('success', $barang->nama_barang . ' ditambahkan ke keranjang');
    }

    public function hapusKeranjang($id)
    {
        $keranjang = session()->get('cart', []);

        if(isset($keranjang[$id])){

            unset($keranjang[$id]);

            session()->put('cart', $keranjang);
        }

        return redirect('/transaksi');
    }

    public function beliSekarang($id)
    {
        // Tambahkan barang ke keranjang
        $barang = DB::table('barang')
                    ->where('id_barang', $id)
                    ->first();

        if(!$barang || $barang->stok <= 0) {
            return redirect('/transaksi')->with('error', 'Stok barang tidak tersedia');
        }

        $keranjang = session()->get('cart', []);

        if(isset($keranjang[$id])){
            if($keranjang[$id]['qty'] >= $barang->stok) {
                return redirect('/transaksi')->with('error', 'Qty melebihi stok yang tersedia untuk ' . $barang->nama_barang);
            }
            $keranjang[$id]['qty']++;
        } else {
            $keranjang[$id] = [
                "id" => $barang->id_barang,
                "nama" => $barang->nama_barang,
                "harga" => $barang->harga_jual,
                "qty" => 1,
                "stok_available" => $barang->stok
            ];
        }

        session()->put('cart', $keranjang);

        // Langsung ke transaksi
        return redirect('/transaksi')->with('success', $barang->nama_barang . ' ditambahkan ke keranjang');
    }

    public function checkout()
    {
        $keranjang = session()->get('cart', []);

        if(empty($keranjang)){
            return redirect('/transaksi')->with('error', 'Keranjang kosong');
        }

        $total = 0;
        $total_items = 0;

        DB::beginTransaction();
        try {
            foreach($keranjang as $id => $item){
                $barang = DB::table('barang')->where('id_barang', $id)->lockForUpdate()->first();

                if(!$barang || $barang->stok < $item['qty']){
                    DB::rollBack();
                    return redirect('/transaksi')->with('error', 'Stok tidak cukup untuk ' . $item['nama']);
                }

                // Kurangi stok
                DB::table('barang')->where('id_barang', $id)->update([
                    'stok' => $barang->stok - $item['qty']
                ]);

                $subtotal = $item['harga'] * $item['qty'];
                $total += $subtotal;
                $total_items += $item['qty'];
            }

            DB::commit();

            // Kosongkan keranjang setelah sukses
            session()->forget('cart');

            return redirect('/transaksi')->with('success', 'Checkout berhasil. Total item: ' . $total_items . '. Total harga: Rp ' . number_format($total,0,',','.'));

        } catch(\Exception $e){
            DB::rollBack();
            return redirect('/transaksi')->with('error', 'Terjadi kesalahan saat checkout');
        }
    }
}