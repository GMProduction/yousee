<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.project.project', ['sidebar' => 'project']);
    }


    public function indexTambahProject()
    {
        return view('admin.project.tambahproject', ['sidebar' => 'project']);
    }

    public function indexDetailProject()
    {
        return view('admin.project.detailproject', ['sidebar' => 'project']);
    }

    public function indexBuatHarga()
    {
        return view('admin.project.formharga', ['sidebar' => 'project']);
    }
}
