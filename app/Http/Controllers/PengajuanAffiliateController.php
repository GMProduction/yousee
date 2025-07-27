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

class PengajuanAffiliateController extends CustomController
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

        return view('admin.pengajuan-afiliate', ['sidebar' => 'pengajuan-afiliate']);
    }

    public function postItem()
    {
        $field = \request()->validate(
            [
                'name'     => 'required',
                'address'  => 'required',
                'phone'    => 'required',
                'brand'    => 'required',
                'picName'  => 'required',
                'picPhone' => 'required',
            ]
        );
        $data  = \request()->all();
        if (\request('password')) {
            \request()->validate([
                'password' => 'confirmed|min:8',
            ], [
                'password.confirmed' => 'Password konfirmasi tidak sesuai',
                'password.min'       => 'Password minimal 8 karakter',
            ]);
            $data['password'] = Hash::make(\request('password'));
        }

        if (\request('id')) {
            $vendor = Vendor::find(\request('id'));
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
