<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;

class penawaranController extends Controller
{



    public function index()
    {
        //        return $this->dataTransaksi();
        $trans = [];
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->dataTransaksi())->setPaper('A4', 'potrait')->save('Laporan.pdf');
        // return view('admin/project/penawaran', ['data' => $trans]);
        return $pdf->stream();
    }

    public function dataTransaksi()
    {
        // $trans = Transaksi::with(['user']);
        $trans = [];
        $start = \request('start');
        $end = \request('end');
        // if (\request('start')) {
        //     $trans = $trans->whereBetween('created_at', ["$start 00:00:00", "$end 23:59:59"]);
        // }
        // $trans = $trans->get();
        return view('admin/project/penawaran', ['data' => $trans]);
    }
}
