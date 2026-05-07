<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $barang = DB::table('barang')->get();
        $cart = session('cart', []);

        return view('transaksi', compact('barang','cart'));
    }
}