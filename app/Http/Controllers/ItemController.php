<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use App\Models\Item;
use App\Models\type;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\DataTables;

class ItemController extends CustomController
{
    //

    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatable()
    {
        $province = \request('province');
        $city = \request('city');
        $type = \request('type');
        $position = \request('position');
        $item = Item::with('city');
        if ($city){
            $item = $item->where('city_id', $city);
        }
        if ($province){
            $item = $item->whereHas('city', function ($q) use ($province) {
                return $q->where('province_id',$province);
            });
        }
        if ($type){
            $item = $item->where('type_id', $type);
        }
        if ($position){
            $item = $item->where('position', $position);
        }
        return DataTables::of($item)->make(true);
    }

    public function cardItem()
    {
        $type = type::all();
        $data = [];
        foreach ($type as $typ) {
            $param    = $typ->name;
            $icon    = $typ->icon;
            $item     = Item::whereHas(
                'type',
                function ($q) use ($param) {
                    return $q->where('name', $param);
                }
            )->count('*');
            $typeItem = [
                'name'  => $param,
                'icon'  => $icon,
                'count' => $item,
            ];
            array_push($data, $typeItem);
        }

        return $data;
    }

    public function getType()
    {
        return type::all();
    }

    public function postItem()
    {
        $data   = \request()->validate(
            [
                'name'      => 'required',
                'address'   => 'required',
                'latitude'  => 'required',
                'longitude' => 'required',
                'city_id'   => 'required',
                'location'  => 'required',
                'url'       => 'required',
                'type_id'   => 'required',
                'position'  => 'required',
                'width'     => 'required',
                'height'    => 'required',
            ]
        );
        $image1 = \request('image1');
        $image2 = \request('image2');
        $image3 = \request('image3');

        if ($image1) {
            $image     = $this->generateImageName('image1');
            $stringImg = '/images/item/'.$image;
            $this->uploadImage('image1', $image, 'imageItem');
            Arr::set($data, 'image1', $stringImg);
        }
        if ($image2) {
            $image     = $this->generateImageName('image2');
            $stringImg = '/images/item/'.$image;
            $this->uploadImage('image2', $image, 'imageItem');
            Arr::set($data, 'image2', $stringImg);
        }
        if ($image3) {
            $image     = $this->generateImageName('image3');
            $stringImg = '/images/item/'.$image;
            $this->uploadImage('image3', $image, 'imageItem');
            Arr::set($data, 'image3', $stringImg);
        }

        if (\request('id')) {
            $item = Item::find(\request('id'));
            Arr::set($data, 'last_update_by', auth()->id());

            if ($image1 && $item->image1){
                if (file_exists('../public'.$item->image1)) {
                    unlink('../public'.$item->image1);
                }
            }
            if ($image1 && $item->image2){
                if (file_exists('../public'.$item->image2)) {
                    unlink('../public'.$item->image2);
                }
            }
            if ($image1 && $item->image3){
                if (file_exists('../public'.$item->image3)) {
                    unlink('../public'.$item->image3);
                }
            }
            $item->update($data);
        } else {
            Arr::set($data, 'created_by', auth()->id());
            $item = Item::create($data);
        }

        $history = new HistoryController();
        $history->postHistory($item->id);

        return response()->json(
            [
                'msg' => 'berhasil',
            ],
            200
        );
    }
}
