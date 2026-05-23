<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use App\Models\Item;
use App\Models\type;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class VendorController extends CustomController
{

    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatable()
    {
        $vendor = Vendor::all();
        foreach ($vendor as $key => $ven) {
            $item = Item::where('vendor_id', $ven->id)->count('id');
            Arr::add($vendor[$key], 'item', $item);
        }

        return DataTables::of($vendor)
                         ->addColumn('pass', function ($data) {
                             return $data->password ? true : false;
                         })
                         ->removeColumn('password')
                         ->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index()
    {

        if (\request()->isMethod('POST')) {
            return $this->postItem();
        }

        return view('admin.vendor', ['sidebar' => 'vendor']);
    }

    public function postItem()
    {
        $id = \request('id');
        if ($id === 'undefined' || $id === 'null' || trim($id) === '') {
            $id = null;
        }

        $rules = [
            'name'     => 'required',
            'address'  => 'required',
            'phone'    => 'required',
            'brand'    => 'required',
            'picName'  => 'required',
            'picPhone' => 'required',
            'email'    => 'nullable|email|unique:vendors,email' . ($id ? ',' . $id : ''),
        ];

        $messages = [
            'name.required'     => 'Nama CV / PT wajib diisi.',
            'address.required'  => 'Alamat wajib diisi.',
            'phone.required'    => 'No. Telp Kantor wajib diisi.',
            'brand.required'    => 'Brand wajib diisi.',
            'picName.required'  => 'Nama PIC wajib diisi.',
            'picPhone.required' => 'Nomor PIC wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',
        ];

        $validated = \request()->validate($rules, $messages);

        $data = [
            'name'     => $validated['name'],
            'address'  => $validated['address'],
            'phone'    => $validated['phone'],
            'brand'    => $validated['brand'],
            'picName'  => $validated['picName'],
            'picPhone' => $validated['picPhone'],
            'email'    => $validated['email'],
        ];

        if (\request('password')) {
            \request()->validate([
                'password' => 'confirmed|min:8',
            ], [
                'password.confirmed' => 'Password konfirmasi tidak sesuai.',
                'password.min'       => 'Password minimal 8 karakter.',
            ]);
            $data['password'] = Hash::make(\request('password'));
        }

        if ($id) {
            $vendor = Vendor::find($id);
            if (!$vendor) {
                return response()->json([
                    'errors' => [
                        'id' => ['Data vendor tidak ditemukan atau sudah dihapus.']
                    ]
                ], 422);
            }
            $vendor->update($data);
        } else {
            Vendor::create($data);
        }

        return response()->json(
            [
                'msg' => 'berhasil',
            ],
            200
        );
    }

    public function getVendor()
    {
        return Vendor::all();
    }

    public function delete($id)
    {
        Vendor::where('id', '=', $id)->delete();

        return 'berhasil';
    }
}
