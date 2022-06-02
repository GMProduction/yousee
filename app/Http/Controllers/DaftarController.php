<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DaftarController extends Controller
{
    public function index(){
        return view('auth.daftar');
    }


    public function store(){
        return request()->all();
    }
}
