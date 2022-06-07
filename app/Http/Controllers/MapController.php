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
            $data = Item::all();
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
}
