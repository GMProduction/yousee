<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalonVendor;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class CalonVendorAdminController extends Controller
{
    public function index()
    {
        return view('admin.pengajuan-mitra',  ['sidebar' => 'calon-vendor']);
    }

    public function data()
    {
        $data = CalonVendor::query();

        return DataTables::of($data)
            ->addColumn('uuid', function ($row) {
                return $row->id;
            })
            ->addColumn('titik_file', function ($row) {
                if ($row->titik_file) {
                    $url = base_url() .  $row->titik_file;
                    return '<a href="' . $url . '" target="_blank">Lihat File</a>';
                }
                return '-';
            })
            ->addColumn('aksi_status', function ($row) {
                return '
        <button class="btn btn-sm btn-success btn-aksi" data-id="' . $row->id . '" data-aksi="terima">Terima</button>
        <button class="btn btn-sm btn-danger btn-aksi" data-id="' . $row->id . '" data-aksi="tolak">Tolak</button>
            ';
            })
            ->addColumn('aksi_lainnya', function ($calonVendor) {
                return '
                <button class="btn btn-sm btn-danger btn-aksi" data-id="' . $calonVendor->id . '" data-aksi="hapus">Hapus</button>
                <button class="btn btn-sm btn-primary btn-aksi" data-id="' . $calonVendor->id . '" data-aksi="whatsapp">Bagikan WA</button>
            ';
            })
            ->rawColumns(['aksi_status', 'aksi_lainnya', 'titik_file'])
            ->make(true);
    }


    public function updateStatus(Request $request, $id)
    {
        $calonVendor = CalonVendor::findOrFail($id);
        $statusBaru = $request->status;
        $calonVendor->status = $statusBaru;
        $calonVendor->save();

        if ($statusBaru === 'diterima') {
            // Cek apakah vendor dengan email tersebut sudah ada
            $vendorExists = Vendor::where('email', $calonVendor->email)->exists();

            if (!$vendorExists) {
                Vendor::create([
                    'name'      => $calonVendor->nama_perusahaan,
                    'brand'     => $calonVendor->brand_vendor,
                    'address'   => $calonVendor->alamat,
                    'email'     => $calonVendor->email,
                    'phone'     => $calonVendor->nophone,
                    'picName'   => $calonVendor->pic,
                    'picPhone'  => $calonVendor->nomor_pic,
                    'password'  => Hash::make($calonVendor->nophone),
                ]);
            }
        }
        return response()->json(['success' => true, 'message' => 'Status berhasil diubah']);
    }

    public function hapus($id)
    {
        try {
            $calonVendor = CalonVendor::where('id', $id)->first();

            if (!$calonVendor) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            $calonVendor->delete();

            return response()->json(['message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data', 'error' => $e->getMessage()], 500);
        }
    }
}
