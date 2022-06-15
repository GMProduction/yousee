<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use App\Models\Item;
use App\Models\type;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
        foreach ($vendor as $key =>  $ven){
            $item = Item::where('vendor_id',$ven->id)->count('id');
            Arr::add($vendor[$key],'item', $item);
        }
        return DataTables::of($vendor)->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index()
    {

        if (\request()->isMethod('POST')){
            return $this->postItem();
        }
        return view('admin.vendor', ['sidebar' => 'vendor']);
    }

    public function postItem()
    {
        $field = \request()->validate(
            [
                'name'    => 'required',
                'address' => 'required',
                'phone'   => 'required',
            ]
        );

        if (\request('id')){
            $vendor = Vendor::find(\request('id'));
            $vendor->update($field);
        }else{
            Vendor::create($field);
        }

        return response()->json(
            [
                'msg' => 'berhasil',
            ],
            200
        );
    }

    public function getVendor(){
        return Vendor::all();
    }
}
