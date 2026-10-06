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
            $allItems = Item::with('type')
                ->select('id', 'vendor_id', 'width', 'height', 'address', 'latitude', 'longitude', 'type_id')
                ->where('is_duplicate_resolved', 0)
                ->get();
            
            // Group items by vendor
            $byVendor = [];
            foreach ($allItems as $itemA) {
                if (!$itemA->vendor_id) continue;
                $byVendor[$itemA->vendor_id][] = $itemA;
            }

            $duplicateIds = [];
            foreach ($byVendor as $vendorId => $groupItems) {
                $groupCount = count($groupItems);
                if ($groupCount <= 1) continue;

                for ($i = 0; $i < $groupCount; $i++) {
                    $itemA = $groupItems[$i];
                    $isDuplicate = false;

                    for ($j = 0; $j < $groupCount; $j++) {
                        if ($i === $j) continue;
                        $itemB = $groupItems[$j];

                        if ($this->isItemDuplicate($itemA, $itemB)) {
                            $isDuplicate = true;
                            break;
                        }
                    }

                    if ($isDuplicate) {
                        $duplicateIds[] = $itemA->id;
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
        
        $inputTrafic = intval(\request('trafic'));
        if ($inputTrafic <= 0) {
            $typeObj = type::find($data['type_id']);
            $typeName = $typeObj ? $typeObj->name : '';
            $inputTrafic = self::calculateSmartTraffic(
                $typeName,
                $data['width'] ?? '0',
                $data['height'] ?? '0',
                $data['address'] ?? '',
                $data['location'] ?? ''
            );
        }
        Arr::set($data, 'trafic', $inputTrafic);

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

        $id = \request('id');
        $slug = $this->createSlug($data['type_id'], $data['city_id'], $data['address'], $id);
        Arr::set($data, 'slug', $slug);

        if ($id) {
            $item = Item::find($id);
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
            Arr::set($data, 'isShow', 1);
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
        $address   = \request('address');
        $width     = \request('width');
        $height    = \request('height');
        $vendor_id = \request('vendor_id');
        $latlong   = \request('latlong');
        $latitude  = \request('latitude');
        $longitude = \request('longitude');
        $type_id   = \request('type_id');
        $id        = \request('id');

        if (!$vendor_id || (!$address && !$latlong && (!$latitude || !$longitude))) {
            return response()->json(['duplicate' => false]);
        }

        if ($latlong && ($latitude === null || $longitude === null)) {
            $parts = explode(',', str_replace(' ', '', $latlong));
            if (count($parts) >= 2) {
                $latitude = $parts[0];
                $longitude = $parts[1];
            }
        }

        // Cari item dari database dengan vendor yang sama
        $items = Item::with(['city.province', 'type', 'vendorAll'])
            ->where('vendor_id', $vendor_id)
            ->where('is_duplicate_resolved', 0);
        if ($id) {
            $items = $items->where('id', '!=', $id);
        }
        $items = $items->get();

        $inputItem = (object) [
            'id' => $id,
            'vendor_id' => $vendor_id,
            'width' => $width,
            'height' => $height,
            'address' => $address,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'type_id' => $type_id,
        ];
        if ($type_id) {
            $inputItem->type = type::find($type_id);
        }

        $duplicateItems = [];
        foreach ($items as $item) {
            $reason = '';
            $similarityText = '';
            if ($this->isItemDuplicate($inputItem, $item, $reason, $similarityText)) {
                $duplicateItems[] = [
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
                    'similarity' => $similarityText,
                    'reason' => $reason
                ];
            }
        }

        if (count($duplicateItems) > 0) {
            return response()->json([
                'duplicate' => true,
                'message' => "Data mirip terdeteksi! Terdapat " . count($duplicateItems) . " titik yang terindikasi sama.",
                'duplicate_items' => $duplicateItems
            ]);
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
        $targetItem = Item::with(['city.province', 'type', 'vendorAll'])->findOrFail($id);
        
        $v1 = $targetItem->vendor_id;
        if (!$v1) {
            return response()->json([]);
        }

        // Cari item lain (bukan targetItem itu sendiri) dengan vendor yang sama
        $allItems = Item::with(['city.province', 'type', 'vendorAll'])
            ->where('vendor_id', $v1)
            ->where('id', '!=', $id)
            ->where('is_duplicate_resolved', 0)
            ->get();

        $duplicates = [];
        foreach ($allItems as $itemB) {
            $reason = '';
            $similarityText = '';
            if ($this->isItemDuplicate($targetItem, $itemB, $reason, $similarityText)) {
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
                    'similarity' => $similarityText,
                    'reason' => $reason
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

        // Group items in memory by vendor
        $groupedByVendor = [];
        foreach ($allItems as $item) {
            if (!$item->vendor_id) continue;
            $groupedByVendor[$item->vendor_id][] = $item;
        }

        // Cari semua kelompok duplikat (clusters)
        $groups = [];
        foreach ($groupedByVendor as $vendorId => $groupItems) {
            $groupCount = count($groupItems);
            if ($groupCount <= 1) continue;

            // List of clusters. Each cluster is an array of items.
            $clusters = [];

            foreach ($groupItems as $item) {
                $matchedClusterIndices = [];

                // Cek apakah item ini duplikat dengan salah satu item di cluster yang sudah ada
                foreach ($clusters as $cIdx => $cluster) {
                    foreach ($cluster as $existingItem) {
                        if ($this->isItemDuplicate($item, $existingItem)) {
                            $matchedClusterIndices[] = $cIdx;
                            break; // Pecahkan loop existingItem
                        }
                    }
                }

                if (empty($matchedClusterIndices)) {
                    $clusters[] = [$item];
                } else {
                    // Gabungkan ke cluster pertama yang cocok
                    $firstIdx = $matchedClusterIndices[0];
                    $clusters[$firstIdx][] = $item;

                    // Jika item ini menjembatani beberapa cluster yang sudah ada, satukan cluster tersebut
                    if (count($matchedClusterIndices) > 1) {
                        for ($m = count($matchedClusterIndices) - 1; $m >= 1; $m--) {
                            $mergeIdx = $matchedClusterIndices[$m];
                            foreach ($clusters[$mergeIdx] as $mItem) {
                                $clusters[$firstIdx][] = $mItem;
                            }
                            unset($clusters[$mergeIdx]);
                        }
                        $clusters = array_values($clusters);
                    }
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

            // Hitung detail kesamaan antar item
            $similarityDetails = [];
            for ($k = 1; $k < count($rawGroup); $k++) {
                $item0 = $rawGroup[0];
                $itemK = $rawGroup[$k];
                $reason = '';
                $simText = '';
                if ($this->isItemDuplicate($item0, $itemK, $reason, $simText)) {
                    if ($simText !== '') {
                        $similarityDetails[] = $simText;
                    }
                } else {
                    // Cek hubungan dengan item sebelumnya jika tidak langsung cocok dengan item0
                    for ($prev = 1; $prev < $k; $prev++) {
                        if ($this->isItemDuplicate($rawGroup[$prev], $itemK, $reason, $simText)) {
                            if ($simText !== '') {
                                $similarityDetails[] = $simText;
                            }
                            break;
                        }
                    }
                }
            }
            $similarityText = !empty($similarityDetails) ? implode('; ', array_unique($similarityDetails)) : 'Terindikasi Duplikat';

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
            // Get all existing non-empty slugs to prevent collisions
            $existingSlugs = Item::whereNotNull('slug')
                ->where('slug', '!=', '')
                ->pluck('slug')
                ->toArray();
            
            // Convert to associative array for O(1) lookup
            $usedSlugs = array_fill_keys($existingSlugs, true);

            // Fetch all items that need a slug
            $items = Item::with(['type', 'city'])
                ->where(function($q) {
                    $q->whereNull('slug')->orWhere('slug', '');
                })
                ->get();

            foreach ($items as $item) {
                // Generate base slug
                $slugParts = ['sewa'];
                if ($item->type) {
                    $slugParts[] = strtolower(str_replace(' ', '-', $item->type->name));
                }
                if ($item->city) {
                    $cityName = $item->city->name;
                    if (stripos($cityName, 'Kota ') === 0) {
                        $cityName = substr($cityName, 5);
                    } elseif (stripos($cityName, 'Kabupaten ') === 0) {
                        $cityName = substr($cityName, 10);
                    }
                    $slugParts[] = strtolower(str_replace(' ', '-', $cityName));
                }
                
                $addressClean = str_replace(['.', ','], '', $item->address);
                $slugParts[] = strtolower(str_replace(' ', '-', $addressClean));
                
                $baseSlug = implode('-', $slugParts);
                $baseSlug = preg_replace('/-+/', '-', $baseSlug);
                $baseSlug = trim($baseSlug, '-');

                $slug = $baseSlug;
                $counter = 1;
                while (isset($usedSlugs[$slug])) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }

                // Mark as used
                $usedSlugs[$slug] = true;

                // Update the item
                $item->slug = $slug;
                $item->save();
            }

            DB::commit();
            return 'success';
        } catch (\Exception $er) {
            DB::rollBack();
            return 'error: ' . $er->getMessage();
        }
    }

    private function createSlug($typeId, $cityId, $address, $itemId = null)
    {
        $type = type::find($typeId);
        $city = \App\Models\City::find($cityId);
        
        $slugParts = ['sewa'];
        if ($type) {
            $slugParts[] = strtolower(str_replace(' ', '-', $type->name));
        }
        if ($city) {
            $cityName = $city->name;
            if (stripos($cityName, 'Kota ') === 0) {
                $cityName = substr($cityName, 5);
            } elseif (stripos($cityName, 'Kabupaten ') === 0) {
                $cityName = substr($cityName, 10);
            }
            $slugParts[] = strtolower(str_replace(' ', '-', $cityName));
        }
        
        // Remove periods and commas, replace spaces with dashes, lowercase it
        $addressClean = str_replace(['.', ','], '', $address);
        $slugParts[] = strtolower(str_replace(' ', '-', $addressClean));
        
        $baseSlug = implode('-', $slugParts);
        // Clean multiple consecutive dashes
        $baseSlug = preg_replace('/-+/', '-', $baseSlug);
        $baseSlug = trim($baseSlug, '-');

        // Check uniqueness and append suffix if duplicate exists
        $slug = $baseSlug;
        $counter = 1;
        
        while (true) {
            $query = Item::where('slug', $slug);
            if ($itemId) {
                $query->where('id', '!=', $itemId);
            }
            if (!$query->exists()) {
                break;
            }
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }

    private static $cachedTypes = null;

    public static function parseCoordinate($val)
    {
        if ($val === null || $val === '') {
            return null;
        }
        $clean = trim(str_replace([' ', ','], ['', '.'], strval($val)));
        if (!is_numeric($clean)) {
            return null;
        }
        return floatval($clean);
    }

    public static function calculateDistanceInMeters($lat1, $lon1, $lat2, $lon2)
    {
        $lat1 = self::parseCoordinate($lat1);
        $lon1 = self::parseCoordinate($lon1);
        $lat2 = self::parseCoordinate($lat2);
        $lon2 = self::parseCoordinate($lon2);

        if ($lat1 === null || $lon1 === null || $lat2 === null || $lon2 === null) {
            return null;
        }

        // Abaikan koordinat default / kosong (0, 0)
        if (($lat1 == 0.0 && $lon1 == 0.0) || ($lat2 == 0.0 && $lon2 == 0.0)) {
            return null;
        }

        $earthRadius = 6371000; // Radius bumi dalam meter

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo   = deg2rad($lat2);
        $lonTo   = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

    private function getTypeName($typeId)
    {
        if (self::$cachedTypes === null) {
            self::$cachedTypes = type::all()->pluck('name', 'id')->toArray();
        }
        return self::$cachedTypes[$typeId] ?? '';
    }

    private function isSameType($typeIdA, $typeIdB, $typeNameA = null, $typeNameB = null)
    {
        if (!empty($typeIdA) && !empty($typeIdB) && $typeIdA == $typeIdB) {
            return true;
        }

        if (empty($typeNameA) && !empty($typeIdA)) {
            $typeNameA = $this->getTypeName($typeIdA);
        }
        if (empty($typeNameB) && !empty($typeIdB)) {
            $typeNameB = $this->getTypeName($typeIdB);
        }

        if (!empty($typeNameA) && !empty($typeNameB)) {
            $a = strtolower(trim($typeNameA));
            $b = strtolower(trim($typeNameB));
            if ($a === $b) {
                return true;
            }
            // Kelompok videotron / megatron / led
            $isDigitalA = str_contains($a, 'videotron') || str_contains($a, 'megatron') || str_contains($a, 'led');
            $isDigitalB = str_contains($b, 'videotron') || str_contains($b, 'megatron') || str_contains($b, 'led');
            if ($isDigitalA && $isDigitalB) {
                return true;
            }
            // Kelompok billboard / minibillboard
            $isBbA = str_contains($a, 'billboard');
            $isBbB = str_contains($b, 'billboard');
            if ($isBbA && $isBbB) {
                return true;
            }
            // Kelompok baliho
            $isBalihoA = str_contains($a, 'baliho');
            $isBalihoB = str_contains($b, 'baliho');
            if ($isBalihoA && $isBalihoB) {
                return true;
            }
        }

        return false;
    }

    /**
     * Memeriksa apakah dua item dianggap duplikat.
     * Kriteria 1: Radius <= 200 meter dan jenisnya sama (meskipun alamat, orientasi, ukuran berbeda).
     * Kriteria 2: Ukuran (lebar & tinggi) sama dan alamat mirip (>= 80% atau nama jalan mirip).
     * Keduanya harus memiliki vendor yang sama.
     */
    private function isItemDuplicate($itemA, $itemB, &$reason = '', &$similarityText = '')
    {
        // Harus vendor yang sama
        $vA = is_object($itemA) ? ($itemA->vendor_id ?? null) : ($itemA['vendor_id'] ?? null);
        $vB = is_object($itemB) ? ($itemB->vendor_id ?? null) : ($itemB['vendor_id'] ?? null);
        if (empty($vA) || empty($vB) || $vA != $vB) {
            return false;
        }

        // Jangan bandingkan item dengan dirinya sendiri
        $idA = is_object($itemA) ? ($itemA->id ?? null) : ($itemA['id'] ?? null);
        $idB = is_object($itemB) ? ($itemB->id ?? null) : ($itemB['id'] ?? null);
        if (!empty($idA) && !empty($idB) && $idA == $idB) {
            return false;
        }

        $isDup = false;
        $reasons = [];
        $simParts = [];

        // 1. CEK RADIUS & JENIS: dalam radius 200 meter dan jenisnya sama
        $latA = is_object($itemA) ? ($itemA->latitude ?? null) : ($itemA['latitude'] ?? null);
        $lonA = is_object($itemA) ? ($itemA->longitude ?? null) : ($itemA['longitude'] ?? null);
        $latB = is_object($itemB) ? ($itemB->latitude ?? null) : ($itemB['latitude'] ?? null);
        $lonB = is_object($itemB) ? ($itemB->longitude ?? null) : ($itemB['longitude'] ?? null);

        $distance = self::calculateDistanceInMeters($latA, $lonA, $latB, $lonB);

        $typeIdA = is_object($itemA) ? ($itemA->type_id ?? null) : ($itemA['type_id'] ?? null);
        $typeIdB = is_object($itemB) ? ($itemB->type_id ?? null) : ($itemB['type_id'] ?? null);
        $typeNameA = is_object($itemA) && isset($itemA->type) && $itemA->type ? ($itemA->type->name ?? '') : (is_object($itemA) ? ($itemA->type_name ?? '') : ($itemA['type_name'] ?? ''));
        $typeNameB = is_object($itemB) && isset($itemB->type) && $itemB->type ? ($itemB->type->name ?? '') : (is_object($itemB) ? ($itemB->type_name ?? '') : ($itemB['type_name'] ?? ''));

        $sameType = $this->isSameType($typeIdA, $typeIdB, $typeNameA, $typeNameB);

        if ($distance !== null && $distance <= 200 && $sameType) {
            $isDup = true;
            $distMeters = round($distance);
            $typeLabel = $typeNameA ?: ($typeNameB ?: $this->getTypeName($typeIdA) ?: 'Jenis Sama');
            $reasons[] = "Radius {$distMeters}m & Jenis Sama ({$typeLabel})";
            $simParts[] = "Radius {$distMeters}m ({$typeLabel})";
        }

        // 2. CEK UKURAN & ALAMAT: ukuran sama dan alamat mirip
        $wA = is_object($itemA) ? ($itemA->width ?? '0') : ($itemA['width'] ?? '0');
        $hA = is_object($itemA) ? ($itemA->height ?? '0') : ($itemA['height'] ?? '0');
        $wB = is_object($itemB) ? ($itemB->width ?? '0') : ($itemB['width'] ?? '0');
        $hB = is_object($itemB) ? ($itemB->height ?? '0') : ($itemB['height'] ?? '0');

        $w1 = floatval(str_replace([',', ' '], '', $wA));
        $h1 = floatval(str_replace([',', ' '], '', $hA));
        $w2 = floatval(str_replace([',', ' '], '', $wB));
        $h2 = floatval(str_replace([',', ' '], '', $hB));

        $addrA = is_object($itemA) ? ($itemA->address ?? '') : ($itemA['address'] ?? '');
        $addrB = is_object($itemB) ? ($itemB->address ?? '') : ($itemB['address'] ?? '');
        $addr1 = strtolower(trim($addrA));
        $addr2 = strtolower(trim($addrB));

        if ($w1 > 0 && $h1 > 0 && $w1 === $w2 && $h1 === $h2 && $addr1 !== '' && $addr2 !== '') {
            $addrPercent = 0;
            if ($this->isAddressDuplicate($addr1, $addr2, $addrPercent)) {
                $isDup = true;
                $roundedAddrPercent = round($addrPercent, 1);
                $reasons[] = "Ukuran sama & Alamat mirip ({$roundedAddrPercent}%)";
                $simParts[] = "{$roundedAddrPercent}% (Alamat)";
            }
        }

        if ($isDup) {
            $reason = implode(' | ', $reasons);
            $similarityText = implode(' | ', $simParts);
            return true;
        }

        return false;
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

    /**
     * Menghitung estimasi trafik otomatis berdasarkan tipe, ukuran, dan lokasi (0 API Call)
     */
    /**
     * Menghitung estimasi trafik persis seperti algoritma bawaan Geospasial (calculateSmartProfile)
     */
    public static function calculateSmartTraffic($typeName, $width, $height, $address, $location, $itemId = 0)
    {
        // Base Traffic (Minimum daily views for any billboard)
        $baseTraffic = 15000;

        // 1. FACTOR: MEDIA TYPE (Premium media is usually in busier spots)
        $typeMult = 1.0;
        $tName = strtolower($typeName ?? '');
        if (str_contains($tName, 'videotron') || str_contains($tName, 'megatron') || str_contains($tName, 'led')) {
            $typeMult = 2.5; // High traffic density usually
        } elseif (str_contains($tName, 'billboard')) {
            $typeMult = 1.8;
        }

        // 2. FACTOR: SIZE (Larger media = Wider visibility range)
        $w = floatval(str_replace([',', ' '], '', $width ?? '0'));
        $h = floatval(str_replace([',', ' '], '', $height ?? '0'));
        $area = $w * $h;
        $sizeMult = 1.0;
        if ($area > 100) {
            $sizeMult = 1.5;
        } elseif ($area > 50) {
            $sizeMult = 1.25;
        }

        // 3. FACTOR: LOCATION KEYWORDS (Simple heuristic)
        $locMult = 1.0;
        $fullAddr = strtolower(($address ?? '') . ' ' . ($location ?? ''));
        if (str_contains($fullAddr, 'sudirman') || str_contains($fullAddr, 'thamrin') || str_contains($fullAddr, 'gatot')) {
            $locMult = 2.0;
        } elseif (str_contains($fullAddr, 'tol') || str_contains($fullAddr, 'arteri')) {
            $locMult = 1.5;
        } elseif (str_contains($fullAddr, 'alun')) {
            $locMult = 1.3;
        }

        // 4. DAILY FLUCTUATION (Simulate Day-of-Week)
        $dayOfWeek = (int) date('w'); // 0=Sun, 6=Sat
        $dayFactor = 1.0;
        if ($dayOfWeek === 6) {
            $dayFactor = 1.15; // Saturday busy
        } elseif ($dayOfWeek === 0) {
            $dayFactor = 0.85; // Sunday quiet
        }

        // Daily Random Noise (Consistent for the day + item ID)
        $dateStr = date('Y-m-d');
        $seed = 0;
        foreach (str_split($dateStr) as $char) {
            $seed += ord($char);
        }
        $seed += (int) $itemId;
        $randomFactor = 0.90 + (($seed % 20) / 100.0); // 0.90 to 1.10

        return (int) floor($baseTraffic * $typeMult * $sizeMult * $locMult * $dayFactor * $randomFactor);
    }

    /**
     * Sinkronisasi massal data trafik yang 0 atau null menggunakan estimasi geospasial
     */
    public function syncTraffic()
    {
        try {
            $items = Item::with('type')
                ->where(function ($q) {
                    $q->whereNull('trafic')
                      ->orWhere('trafic', 0)
                      ->orWhere('trafic', '');
                })
                ->whereNull('deleted_at')
                ->get();

            $updatedCount = 0;
            foreach ($items as $item) {
                $typeName = $item->type->name ?? '';
                $trafficVal = self::calculateSmartTraffic(
                    $typeName,
                    $item->width,
                    $item->height,
                    $item->address,
                    $item->location,
                    $item->id
                );

                $item->update([
                    'trafic' => $trafficVal
                ]);
                $updatedCount++;
            }

            return $this->jsonResponse('Berhasil menyinkronkan ' . $updatedCount . ' data trafik titik yang masih 0.', 200, [
                'updated_count' => $updatedCount
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse('Gagal sinkronisasi: ' . $e->getMessage(), 500);
        }
    }
}

