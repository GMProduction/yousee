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
            $allItems = Item::select('id', 'vendor_id', 'width', 'height', 'address')->where('is_duplicate_resolved', 0)->get();
            
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

                        if ($this->isAddressDuplicate($addr1, $addr2)) {
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
        $items = Item::where('vendor_id', $vendor_id)->where('is_duplicate_resolved', 0);
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
                // Perbandingan alamat menggunakan isAddressDuplicate
                $addr1 = strtolower(trim($address));
                $addr2 = strtolower(trim($item->address));

                if ($this->isAddressDuplicate($addr1, $addr2, $percent)) {
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

            $isDup = $this->isAddressDuplicate($addr1, $addr2, $percent);

            if ($isDup) {
                $duplicates[] = [
                    'id' => $itemB->id,
                    'name' => $itemB->name,
                    'address' => $itemB->address,
                    'city' => $itemB->city ? $itemB->city->name : '-',
                    'province' => $itemB->city && $itemB->city->province ? $itemB->city->province->name : '-',
                    'type' => $itemB->type ? $itemB->type->name : '-',
                    'width' => $itemB->width,
                    'height' => $itemB->height,
                    'vendor' => $itemB->vendorAll ? $itemB->vendorAll->name : '-',
                    'latitude' => $itemB->latitude,
                    'longitude' => $itemB->longitude,
                    'image1' => $itemB->image1 ? url($itemB->image1) : '',
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

    public function getDuplicatePairs()
    {
        // Ambil semua item aktif yang belum diselesaikan duplikatnya
        $allItems = Item::with(['city.province', 'type', 'vendorAll'])
            ->where('is_duplicate_resolved', 0)
            ->get();

        // Group items in memory by vendor, width, and height
        $grouped = [];
        foreach ($allItems as $item) {
            $v = $item->vendor_id;
            $w = floatval(str_replace([',', ' '], '', $item->width ?? '0'));
            $h = floatval(str_replace([',', ' '], '', $item->height ?? '0'));
            $addr = strtolower(trim($item->address ?? ''));
            if ($addr === '') continue;

            $key = $v . '_' . $w . '_' . $h;
            $grouped[$key][] = $item;
        }

        // Cari semua kelompok duplikat (clusters)
        $groups = [];
        foreach ($grouped as $key => $groupItems) {
            $groupCount = count($groupItems);
            if ($groupCount <= 1) continue;

            // List of clusters. Each cluster is an array of items.
            $clusters = [];

            foreach ($groupItems as $item) {
                $addr1 = strtolower(trim($item->address ?? ''));
                $matchedClusterIndex = -1;

                // Cek apakah item ini mirip dengan salah satu item di cluster yang sudah ada
                foreach ($clusters as $cIdx => $cluster) {
                    foreach ($cluster as $existingItem) {
                        $addr2 = strtolower(trim($existingItem->address ?? ''));

                        if ($this->isAddressDuplicate($addr1, $addr2)) {
                            $matchedClusterIndex = $cIdx;
                            break 2; // Pecahkan loop cluster dan loop existingItem
                        }
                    }
                }

                if ($matchedClusterIndex !== -1) {
                    $clusters[$matchedClusterIndex][] = $item;
                } else {
                    $clusters[] = [$item];
                }
            }

            // Simpan hanya cluster yang memiliki anggota > 1 (ada duplikat)
            foreach ($clusters as $cluster) {
                if (count($cluster) > 1) {
                    $groups[] = $cluster;
                }
            }
        }

        // Paginate groups: page starts at 1
        $totalGroups = count($groups);
        $page = intval(\request('page', 1));
        if ($page < 1) $page = 1;

        $group = null;
        if ($totalGroups > 0 && isset($groups[$page - 1])) {
            $rawGroup = $groups[$page - 1];
            
            // Format items inside the group
            $formattedItems = [];
            foreach ($rawGroup as $item) {
                $formattedItems[] = [
                    'id' => $item->id,
                    'name' => $item->name ?? '-',
                    'type' => $item->type ? $item->type->name : '-',
                    'province' => $item->city && $item->city->province ? $item->city->province->name : '-',
                    'city' => $item->city ? $item->city->name : '-',
                    'address' => $item->address,
                    'width' => $item->width,
                    'height' => $item->height,
                    'vendor' => $item->vendorAll ? $item->vendorAll->name : '-',
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                    'image1' => $item->image1 ? url($item->image1) : '',
                ];
            }

            // Calculate similarity percentage relative to the first item
            $addr0 = strtolower(trim($rawGroup[0]->address ?? ''));
            $similarityDetails = [];
            $totalPercent = 0;
            for ($k = 1; $k < count($rawGroup); $k++) {
                $addrK = strtolower(trim($rawGroup[$k]->address ?? ''));
                $this->isAddressDuplicate($addr0, $addrK, $percent);
                $totalPercent += $percent;
                $similarityDetails[] = round($percent, 1) . '%';
            }
            $avgPercent = count($similarityDetails) > 0 ? round($totalPercent / count($similarityDetails), 1) : 100;
            $similarityText = count($similarityDetails) === 1 ? $similarityDetails[0] : $avgPercent . '% (Rata-rata)';

            $group = [
                'items' => $formattedItems,
                'similarity' => $similarityText
            ];
        }

        return response()->json([
            'group' => $group,
            'current_page' => $page,
            'total_pages' => $totalGroups,
        ]);
    }

    public function resolveDuplicate()
    {
        $id = \request('id');
        $item = Item::findOrFail($id);
        $item->update(['is_duplicate_resolved' => 1]);

        return response()->json(['status' => 'success', 'message' => 'Coordinate resolved successfully']);
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

    private function isAddressDuplicate($addr1, $addr2, &$percent = 0)
    {
        $addr1 = strtolower(trim($addr1));
        $addr2 = strtolower(trim($addr2));

        if ($addr1 === '' || $addr2 === '') {
            $percent = 0;
            return false;
        }

        if ($addr1 === $addr2) {
            $percent = 100.0;
            return true;
        }

        // Clean common punctuation for comparison
        $clean1 = str_replace(['.', ',', '-', ' '], '', $addr1);
        $clean2 = str_replace(['.', ',', '-', ' '], '', $addr2);
        if ($clean1 === $clean2) {
            $percent = 100.0;
            return true;
        }

        // Split by comma to extract the street/specific location name (first segment)
        $parts1 = explode(',', $addr1);
        $parts2 = explode(',', $addr2);

        $firstSegment1 = trim($parts1[0]);
        $firstSegment2 = trim($parts2[0]);

        // Clean dots and double spaces in first segments
        $firstSegment1 = preg_replace('/\s+/', ' ', str_replace('.', '', $firstSegment1));
        $firstSegment2 = preg_replace('/\s+/', ' ', str_replace('.', '', $firstSegment2));

        // Check similarity of the first segment (street/building name)
        similar_text($firstSegment1, $firstSegment2, $firstPercent);
        if ($firstPercent < 75) {
            $percent = $firstPercent;
            return false;
        }

        // Jika segmen pertama mirip, cek kemiripan keseluruhan alamat
        similar_text($addr1, $addr2, $overallPercent);
        $percent = $overallPercent;
        if ($overallPercent >= 80) {
            return true;
        }

        return false;
    }
}
