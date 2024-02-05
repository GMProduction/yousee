<?php

namespace App\Http\Controllers;

use App\Export\PenawaranExport;
use App\Import\PemendagriReportExport;
use App\Models\Project;
use App\Models\ProjectItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use function PHPSTORM_META\type;

class penawaranController extends Controller
{

    public function index($id, $logo)
    {
        // return $this->dataTransaksi($id);
        $trans = [];
        $pdf   = App::make('dompdf.wrapper');

        if ($logo == 1) {
            $pdf->loadHTML($this->dataTransaksi($id))->setPaper('A4', 'potrait')->save('Laporan.pdf');
        } else {
            $pdf->loadHTML($this->exportpdfinternal($id))->setPaper('A4', 'potrait')->save('Laporan.pdf');
        }

        //        $data = $this->dataTransaksi($id);
        //         return view('admin/project/penawaran', ['data' => $data]);
        return $pdf->stream();
    }

    public function dataTransaksi($id)
    {
        $data  = Project::with(['items.city', 'items.item'])->findOrFail($id);
        $item = ProjectItem::with(['city', 'item'])->where('project_id', $id)->orderBy('index_number', 'ASC')->get();
        //        return $data;
        $trans = [];
        $start = \request('start');
        $end   = \request('end');
        $date = Carbon::now()->format('d F Y');
        $this->changeStatusToPengajuan($id);
        // if (\request('start')) {
        //     $trans = $trans->whereBetween('created_at', ["$start 00:00:00", "$end 23:59:59"]);
        // }
        // $trans = $trans->get();
        return view('admin/project/penawaran', ['data' => $data, 'date' => $date, 'item' => $item]);
    }

    public function exportpdfinternal($id)
    {
        $data  = Project::with(['items.city', 'items.item'])->findOrFail($id);
        $item = ProjectItem::with(['city', 'item'])->where('project_id', $id)->orderBy('index_number', 'ASC')->get();
        //        return $data;
        $trans = [];
        $start = \request('start');
        $end   = \request('end');
        $date = Carbon::now()->format('d F Y');
        $this->changeStatusToPengajuan($id);
        // if (\request('start')) {
        //     $trans = $trans->whereBetween('created_at', ["$start 00:00:00", "$end 23:59:59"]);
        // }
        // $trans = $trans->get();
        return view('admin/project/pdfinternal', ['data' => $data, 'date' => $date, 'item' => $item]);
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
