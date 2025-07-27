<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MitraController extends Controller
{
    public function create($id)
    {
        return view('form_mitra', ['id' => $id]); // jika ingin gunakan ID untuk pre-fill
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'address' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'pic_name' => 'required|string',
            'pic_phone' => 'required|string',
            'titik_file' => 'required|file|mimes:pdf,xls,xlsx|max:2048',
        ]);

        if ($request->hasFile('titik_file')) {
            $filePath = $request->file('titik_file')->store('titik_mitra', 'public');
            // Simpan $filePath ke database kalau perlu
        }

        // Simpan ke DB (contoh jika pakai model Mitra)
        // Mitra::create([...]);

        return redirect()->back()->with('message', 'Pengajuan mitra berhasil dikirim!');
    }
}
