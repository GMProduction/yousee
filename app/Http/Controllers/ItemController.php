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
        $province  = \request('province');
        $city      = \request('city');
        $type      = \request('type');
        $position  = \request('position');
        $duplicate = \request('duplicate');
        $item      = Item::with(['vendorAll', 'city', 'itemRent']);

        if ($duplicate) {
            // Cari candidate id yang memiliki vendor_id, width, dan height yang sama dengan titik lain
            $candidates = Item::select('id', 'vendor_id', 'width', 'height', 'address')
                ->whereIn('id', function($q) {
                    $q->select('a.id')
                      ->from('items as a')
                      ->join('items as b', function($join) {
                          $join->on('a.vendor_id', '=', 'b.vendor_id')
                               ->on('a.width', '=', 'b.width')
                               ->on('a.height', '=', 'b.height')
                               ->on('a.id', '<>', 'b.id');
                      })
                      ->whereNull('a.deleted_at')
                      ->whereNull('b.deleted_at');
                })
                ->get();

            $duplicateIds = [];
            $count = count($candidates);
            for ($i = 0; $i < $count; $i++) {
                $itemA = $candidates[$i];
                $addr1 = strtolower(trim($itemA->address));
                $w1 = str_replace([',', ' '], '', $itemA->width);
                $h1 = str_replace([',', ' '], '', $itemA->height);

                for ($j = 0; $j < $count; $j++) {
                    if ($i === $j) continue;
                    $itemB = $candidates[$j];

                    if ($itemA->vendor_id !== $itemB->vendor_id) continue;

                    $w2 = str_replace([',', ' '], '', $itemB->width);
                    $h2 = str_replace([',', ' '], '', $itemB->height);
                    if ($w1 !== $w2 || $h1 !== $h2) continue;

                    $addr2 = strtolower(trim($itemB->address));

                    if ($addr1 === $addr2) {
                        $duplicateIds[] = $itemA->id;
                        break;
                    }

                    similar_text($addr1, $addr2, $percent);
                    if ($percent >= 80) {
                        $duplicateIds[] = $itemA->id;
                        break;
                    }
                }
            }

            $item = $item->whereIn('id', $duplicateIds);
        }

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
        return DataTables::of($item)
            ->addColumn('status', function ($item) {
                // Hitung status berdasarkan latitude dan longitude
                return ($item->latitude < -11.000 || $item->latitude > 6.100 || $item->longitude < 95.000 || $item->longitude > 141.000) ? "SALAH" : "BENAR";
            })
            ->filterColumn('status', function ($query, $keyword) {
                if (strtolower($keyword) === 'salah') {
                    $query->where(function ($q) {
                        $q->where('latitude', '<', -11.000)
                            ->orWhere('latitude', '>', 6.100)
                            ->orWhere('longitude', '<', 95.000)
                            ->orWhere('longitude', '>', 141.000);
                    });
                } elseif (strtolower($keyword) === 'benar') {
                    $query->where(function ($q) {
                        $q->whereBetween('latitude', [-11.000, 6.100])
                            ->whereBetween('longitude', [95.000, 141.000]);
                    });
                }
            })
            ->make(true);
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
            $stringImg = '/images/item/' . $image;
            $this->uploadImage('image1', $image, 'imageItem');
            Arr::set($data, 'image1', $stringImg);
        }
        if ($image2) {
            $image     = $this->generateImageName('image2');
            $stringImg = '/images/item/' . $image;
            $this->uploadImage('image2', $image, 'imageItem');
            Arr::set($data, 'image2', $stringImg);
        }
        if ($image3) {
            $image     = $this->generateImageName('image3');
            $stringImg = '/images/item/' . $image;
            $this->uploadImage('image3', $image, 'imageItem');
            Arr::set($data, 'image3', $stringImg);
        }

        if (\request('id')) {
            $item = Item::find(\request('id'));
            Arr::set($data, 'last_update_by', auth()->id());

            if ($image1 && $item->image1) {
                if (file_exists('../public' . $item->image1)) {
                    unlink('../public' . $item->image1);
                }
            }
            if ($image1 && $item->image2) {
                if (file_exists('../public' . $item->image2)) {
                    unlink('../public' . $item->image2);
                }
            }
            if ($image1 && $item->image3) {
                if (file_exists('../public' . $item->image3)) {
                    unlink('../public' . $item->image3);
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

    public function checkDuplicate()
    {
        $address = \request('address');
        $width = \request('width');
        $height = \request('height');
        $vendor_id = \request('vendor_id');
        $id = \request('id');

        if (!$address || !$width || !$height || !$vendor_id) {
            return response()->json(['duplicate' => false]);
        }

        // Normalisasi ukuran input: hilangkan koma dan spasi
        $cleanWidth = str_replace([',', ' '], '', $width);
        $cleanHeight = str_replace([',', ' '], '', $height);

        // Cari item dari database dengan vendor yang sama
        $items = Item::where('vendor_id', $vendor_id);
        if ($id) {
            $items = $items->where('id', '!=', $id);
        }
        $items = $items->get();

        foreach ($items as $item) {
            // Normalisasi ukuran dari DB
            $dbWidth = str_replace([',', ' '], '', $item->width);
            $dbHeight = str_replace([',', ' '], '', $item->height);

            // Jika ukuran cocok (lebar & tinggi)
            if ($cleanWidth == $dbWidth && $cleanHeight == $dbHeight) {
                // Perbandingan alamat (case-insensitive & trim)
                $addr1 = strtolower(trim($address));
                $addr2 = strtolower(trim($item->address));

                if ($addr1 === $addr2) {
                    return response()->json([
                        'duplicate' => true,
                        'message' => "Data duplikat terdeteksi! Kode: {$item->name}, Alamat: {$item->address}"
                    ]);
                }

                // Cek kemiripan string menggunakan similar_text
                similar_text($addr1, $addr2, $percent);
                if ($percent >= 80) {
                    return response()->json([
                        'duplicate' => true,
                        'message' => "Data mirip terdeteksi! Kode: {$item->name}, Alamat: {$item->address} (Kemiripan " . round($percent, 1) . "%)"
                    ]);
                }
            }
        }

        return response()->json(['duplicate' => false]);
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
                $slug    = $type . '-' . $address . '-' . $d->id;
                $d->update(['slug' => $slug]);
            }
            DB::commit();
            return 'success';
        } catch (\Exception $er) {
            DB::rollBack();
            return 'error: ' . $er->getMessage();
        }
    }
}
