<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    //

    /**
     * @return Province[]|\Illuminate\Database\Eloquent\Collection
     */
    public function province(){
        return Province::all();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function city($id){
        return City::where('province_id',$id)->get();
    }

    /**
     * @return City[]|\Illuminate\Database\Eloquent\Collection
     */
    public function cityAll(){
        return City::all();
    }
}
