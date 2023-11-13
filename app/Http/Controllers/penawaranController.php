<?php

namespace App\Http\Controllers;

use App\Export\PenawaranExport;
use App\Import\PemendagriReportExport;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class penawaranController extends Controller
{

    public function index($id)
    {
        //                        return $this->dataTransaksi($id);
        $trans = [];
        // $pdf   = App::make('dompdf.wrapper');
        // $pdf->loadHTML($this->dataTransaksi($id))->setPaper('A4', 'potrait')->save('Laporan.pdf');

        $data = $this->dataTransaksi($id);
        return view('admin/project/penawaran', ['data' => $data]);
        // return $pdf->stream();
    }

    public function dataTransaksi($id)
    {
        $data  = Project::with(['items.city', 'items.item'])->findOrFail($id);
        return $data;
        $trans = [];
        $start = \request('start');
        $end   = \request('end');
        $date = Carbon::now()->format('d F Y');
        $this->changeStatusToPengajuan($id);
        // if (\request('start')) {
        //     $trans = $trans->whereBetween('created_at', ["$start 00:00:00", "$end 23:59:59"]);
        // }
        // $trans = $trans->get();
        return view('admin/project/penawaran', ['data' => $data, 'date' => $date]);
    }

    /**
     * @return BinaryFileResponse
     */
    public function exportExcel($id)
    {
        $data = Project::findOrFail($id);
        $this->changeStatusToPengajuan($id);
        return Excel::download(new PenawaranExport($id, $data->name), $data->name . '.xlsx');
    }

    public function changeStatusToPengajuan($id)
    {
        $data = Project::findOrFail($id);
        $data->status = "1";
        $data->save();
    }
}
