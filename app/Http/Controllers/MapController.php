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
            $item = Item::with('city');
            if ($city && $city !== 'undefined'){
                $item = $item->where('city_id', $city);
            }
            if ($province && $province !== 'undefined'){
                $item = $item->whereHas('city', function ($q) use ($province) {
                    return $q->where('province_id',$province);
                });
            }
            if ($type && $type !== 'undefined'){
                $item = $item->where('type_id', $type);
            }
            if ($position && $position !== 'undefined'){
                $item = $item->where('position', $position);
            }
            $data = $item->get();
            $geo_json_data = $data->map(function ($place) {
                return [
                    'type' => 'Feature',
                    'properties' => $place,
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [
                            $place->longitude,
                            $place->latitude,

                        ],
                    ],
                ];
            });

            return $this->jsonResponse('success', 200, [
                'type' => 'FeatureCollection',
                'features' => $geo_json_data
            ]);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function get_map_by_id($id)
    {
        try {
            $item = Item::find($id);
            return $this->jsonResponse('success', 200, $item);
        }catch (\Exception $e){
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }
}
