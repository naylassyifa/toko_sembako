<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function show(){
        return view('login');
    }

    public function login(Request $r){
        $cek = DB::table('admin')
        ->where('username',$r->username)
        ->where('password',$r->password)
        ->first();

        if($cek){
            session([
                'login'=>true,
                'user'=>$cek->username
            ]);
            return redirect('/');
        }

        return back();
    }

    public function logout(){
        session()->flush();
        return redirect('/login');
    }
}