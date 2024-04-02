<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use App\Models\Item;
use App\Models\type;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
        $city     = \request('city');
        $type     = \request('type');
        $position = \request('position');
        $item     = Item::with(['vendorAll', 'city', 'itemRent']);

        if ($city) {
            $item = $item->where('city_id', $city);
        }
        if ($province) {
            $item = $item->whereHas(
                'city',
                function ($q) use ($province) {
                    return $q->where('province_id', $province);
                }
            );
        }
        if ($type) {
            $item = $item->where('type_id', $type);
        }
        if ($position) {
            $item = $item->where('position', $position);
        }

        if (auth()->user()->role == 'magang') {
            $item = $item->where('created_by', '=', auth()->id());
        }

//        $item = $item->get()->append(['status_on_rent']);
        return DataTables::of($item)->make(true);
    }

    public function cardItem()
    {
        $type = type::all();
        $data = [];
        foreach ($type as $typ) {
            $param    = $typ->name;
            $icon     = $typ->icon;
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
                'name'      => '',
                'address'   => 'required',
                'latlong'   => 'required',
                'city_id'   => 'required',
                'location'  => 'required',
                'url'       => 'required',
                'type_id'   => 'required',
                'position'  => 'required',
                'width'     => 'required',
                'height'    => 'required',
                'vendor_id' => 'required',
            ]
        );
        $image1 = \request('image1');
        $image2 = \request('image2');
        $image3 = \request('image3');

        $latlong = $data['latlong'];
        $str_arr = preg_split("/\,/", str_replace(' ', '', $latlong));

        Arr::set($data, 'latitude', $str_arr[0]);
        Arr::set($data, 'longitude', $str_arr[1]);
        Arr::set($data, 'qty', \request('qty'));
        Arr::set($data, 'side', \request('side'));
        Arr::set($data, 'trafic', \request('trafic'));

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

            if ($image1 && $item->image1) {
                if (file_exists('../public'.$item->image1)) {
                    unlink('../public'.$item->image1);
                }
            }
            if ($image1 && $item->image2) {
                if (file_exists('../public'.$item->image2)) {
                    unlink('../public'.$item->image2);
                }
            }
            if ($image1 && $item->image3) {
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

    public function getUrlStreetView($id)
    {
        $item = Item::findOrFail($id);

        return $item->url;
    }

    public function delete($id)
    {
        Item::where('id', '=', $id)->delete();

        return 'berhasil';
    }

    public function getItemByID($id)
    {
        return Item::findOrFail($id);
    }

    public function changeShowLandingPage()
    {
        $id   = \request('id');
        $item = Item::find($id);
        $item->update([
            'isShow' => ! $item->isShow,
        ]);

        return 'succees';
    }

    public function generateSlug()
    {
        DB::beginTransaction();
        try {
            $item = Item::all();
            foreach ($item as $d) {
                $address = Str::slug($d->address);
                $type    = Str::slug($d->type->name);
                $slug    = $type.'-'.$address.'-'.$d->id;
                $d->update(['slug' => $slug]);
            }
            DB::commit();
            return 'success';
        }catch (\Exception $er){
            DB::rollBack();
            return 'error: '.$er->getMessage();
        }
    }
}
