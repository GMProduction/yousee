<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Item;

class MapController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.cek-map')->with(['sidebar' => 'beranda']);
    }

    public function get_map_json()
    {
        try {
            $province = \request('province');
            $city = \request('city');
            $type = \request('type');
            $position = \request('position');

            // Select only columns needed for the map markers to reduce payload size
            $item = Item::select([
                'id', 'name', 'latitude', 'longitude', 'type_id', 'city_id', 'vendor_id', 'address', 'location'
            ])->with([
                'type:id,icon,name',
                'city:id,name',
                'vendorAll:id,name'
            ]);

            if ($city && $city !== 'undefined') {
                $item = $item->where('city_id', $city);
            }
            if ($province && $province !== 'undefined') {
                $item = $item->whereHas('city', function ($q) use ($province) {
                    return $q->where('province_id', $province);
                });
            }
            if ($type && $type !== 'undefined') {
                $item = $item->where('type_id', $type);
            }
            if ($position && $position !== 'undefined') {
                $item = $item->where('position', $position);
            }

            // Using cursor or chunking if data is extremely large, 
            // but for 10k records, selecting columns is already a huge win.
            $data = $item->get();

            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function get_map_by_id($id)
    {
        try {
            $item = Item::with('vendorAll')->find($id);
            return $this->jsonResponse('success', 200, $item);
        }catch (\Exception $e){
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }
}
