<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use App\Models\type;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\DataTables;

class VendorController extends CustomController
{

    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatable(){
        return DataTables::of(type::query())->make(true);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        
        return view('admin.vendor', ['sidebar' => 'vendor']);
    }
}
