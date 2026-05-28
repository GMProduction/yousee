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
        \Log::info('Datatable request received. URL: ' . \request()->fullUrl() . ' | params: ' . json_encode(\request()->all()));
        $item      = Item::with(['vendorAll', 'city', 'itemRent']);

        if ($duplicate) {
            // Ambil semua item aktif untuk diproses
            $allItems = Item::select('id', 'vendor_id', 'width', 'height', 'address')->get();
            
            // Group items by vendor, normalized width, and normalized height
            $grouped = [];
            foreach ($allItems as $itemA) {
                $v = $itemA->vendor_id;
                $w = floatval(str_replace([',', ' '], '', $itemA->width ?? '0'));
                $h = floatval(str_replace([',', ' '], '', $itemA->height ?? '0'));
                $addr = strtolower(trim($itemA->address ?? ''));
                if ($addr === '') continue;

                $key = $v . '_' . $w . '_' . $h;
                $grouped[$key][] = [
                    'id' => $itemA->id,
                    'address' => $addr
                ];
            }

            $duplicateIds = [];
            foreach ($grouped as $key => $groupItems) {
                $groupCount = count($groupItems);
                if ($groupCount <= 1) continue;

                for ($i = 0; $i < $groupCount; $i++) {
                    $itemA = $groupItems[$i];
                    $addr1 = $itemA['address'];
                    $isDuplicate = false;

                    for ($j = 0; $j < $groupCount; $j++) {
                        if ($i === $j) continue;
                        $itemB = $groupItems[$j];
                        $addr2 = $itemB['address'];

                        if ($addr1 === $addr2) {
                            $isDuplicate = true;
                            break;
                        }

                        similar_text($addr1, $addr2, $percent);
                        if ($percent >= 80) {
                            $isDuplicate = true;
                            break;
                        }
                    }

                    if ($isDuplicate) {
                        $duplicateIds[] = $itemA['id'];
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

    public function getDuplicates($id)
    {
        $targetItem = Item::findOrFail($id);
        
        $addr1 = strtolower(trim($targetItem->address ?? ''));
        if ($addr1 === '') {
            return response()->json([]);
        }

        $w1 = floatval(str_replace([',', ' '], '', $targetItem->width ?? '0'));
        $h1 = floatval(str_replace([',', ' '], '', $targetItem->height ?? '0'));
        $v1 = $targetItem->vendor_id;

        // Cari item lain (bukan targetItem itu sendiri) dengan vendor yang sama
        $allItems = Item::with(['city', 'type', 'vendorAll'])
            ->where('vendor_id', $v1)
            ->where('id', '!=', $id)
            ->get();

        $duplicates = [];
        foreach ($allItems as $itemB) {
            $w2 = floatval(str_replace([',', ' '], '', $itemB->width ?? '0'));
            $h2 = floatval(str_replace([',', ' '], '', $itemB->height ?? '0'));
            if ($w1 !== $w2 || $h1 !== $h2) continue;

            $addr2 = strtolower(trim($itemB->address ?? ''));
            if ($addr2 === '') continue;

            $isDup = false;
            $percent = 0;
            if ($addr1 === $addr2) {
                $isDup = true;
                $percent = 100.0;
            } else {
                similar_text($addr1, $addr2, $percent);
                if ($percent >= 80) {
                    $isDup = true;
                }
            }

            if ($isDup) {
                $duplicates[] = [
                    'id' => $itemB->id,
                    'name' => $itemB->name,
                    'address' => $itemB->address,
                    'city' => $itemB->city ? $itemB->city->name : '-',
                    'type' => $itemB->type ? $itemB->type->name : '-',
                    'width' => $itemB->width,
                    'height' => $itemB->height,
                    'similarity' => round($percent, 1) . '%'
                ];
            }
        }

        return response()->json($duplicates);
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
