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

        $keranjang = session()->get('cart', []);

        if(isset($keranjang[$id])){

            $keranjang[$id]['qty']++;

        } else {

            $keranjang[$id] = [
                "id" => $barang->id_barang,
                "nama" => $barang->nama_barang,
                "harga" => $barang->harga_jual,
                "qty" => 1
            ];
        }

        session()->put('cart', $keranjang);

        return redirect('/transaksi');
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

    public function checkout()
    {
        session()->forget('cart');

        return redirect('/transaksi')
            ->with('success', 'Checkout berhasil');
    }
}