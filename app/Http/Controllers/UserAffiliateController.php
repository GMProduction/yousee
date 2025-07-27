<?php

namespace App\Http\Controllers;

use App\Models\UserAffiliate;
use Illuminate\Http\Request;

class UserAffiliateController extends Controller
{
    // Tampilkan halaman admin
    public function adminIndex()
    {
        return view('admin.useraffiliate.index');
    }

    // Untuk AJAX DataTable
    public function datatable(Request $request)
    {
        $query = UserAffiliate::query();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        return datatables()->of($query)
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-danger" onclick="hapusData(' . $row->id . ')">Hapus</button>
                    <button class="btn btn-sm btn-success" onclick="ubahStatus(' . $row->id . ', \'diterima\')">Terima</button>
                    <button class="btn btn-sm btn-secondary" onclick="ubahStatus(' . $row->id . ', \'ditolak\')">Tolak</button>
                ';
            })
            ->addColumn('cv', function ($row) {
                return $row->file_upload;
            })
            ->rawColumns(['action'])
            ->make(true);
    }



    public function show($id)
    {
        return UserAffiliate::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
            'nophone' => 'required|string'
        ]);

        $user = UserAffiliate::findOrFail($id);
        $user->update($data);

        return response()->json(['success' => true]);
    }

    // Hapus data
    public function destroy($id)
    {
        $data = UserAffiliate::findOrFail($id);
        $data->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    // Ubah status (terima / tolak)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak'
        ]);

        $data = UserAffiliate::findOrFail($id);
        $data->update(['status' => $request->status]);

        return response()->json(['message' => 'Status berhasil diubah']);
    }
}
