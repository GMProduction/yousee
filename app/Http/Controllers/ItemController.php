<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\type;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\DataTables;

class ItemController extends Controller
{
    //

    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatable(){
        $item = Item::all();
        return DataTables::of($item)->make(true);
    }

    public function cardItem(){
        $type = type::all();
        $data = [];
        foreach ($type as $typ){
            $param = $typ->name;
            $item = Item::whereHas('type', function ($q) use ($param){
                return $q->where('name',$param);
            })->count('*');
            $typeItem = [
              'name' => $param,
              'count' => $item
            ];
            array_push($data,$typeItem);
        }
        return $data;
    }

    public function getType(){
        return type::all();
    }
}
