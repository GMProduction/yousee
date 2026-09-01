<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use Illuminate\Support\Facades\DB;

class GeospasialController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.geospasial_v2');
    }

    public function getData()
    {
        try {
            $province = \request('province');
            $city = \request('city');
            $type = \request('type');
            $position = \request('position');

            $query = DB::table('items')
                ->join('types', 'items.type_id', '=', 'types.id')
                ->leftJoin('cities', 'items.city_id', '=', 'cities.id')
                ->leftJoin('provinces', 'cities.province_id', '=', 'provinces.id')
                ->select(
                    'items.id', 'items.latitude', 'items.longitude', 'items.name',
                    'items.address', 'items.location', 'items.city_id', 'items.type_id',
                    'items.position', 'items.width', 'items.height', 'items.side',
                    'items.image2', 'items.slug', 'items.trafic',
                    'types.name as type_name', 'types.icon as type_icon',
                    'cities.name as city_name',
                    'provinces.id as province_id',
                    'provinces.name as province_name'
                )
                ->whereNull('items.deleted_at')
                ->where('items.isShow', '=', 1);

            if ($city && $city !== 'undefined' && $city !== '') {
                $query->where('items.city_id', $city);
            }
            if ($province && $province !== 'undefined' && $province !== '') {
                $query->where('cities.province_id', $province);
            }
            if ($type && $type !== 'undefined' && $type !== '') {
                $query->where('items.type_id', $type);
            }
            if ($position && $position !== 'undefined' && $position !== '') {
                $query->where('items.position', $position);
            }

            // Ambil semua data titik tanpa batasan limit 2000 untuk Geospasial Admin v2
            $results = $query->get();

            // Mapping ke format nested object yang dibutuhkan frontend geospasial
            $data = $results->map(function ($item) {
                return [
                    'id' => $item->id,
                    'latitude' => $item->latitude,
                    'longitude' => $item->longitude,
                    'name' => $item->name,
                    'address' => $item->address,
                    'location' => $item->location,
                    'city_id' => $item->city_id,
                    'type_id' => $item->type_id,
                    'position' => $item->position,
                    'width' => $item->width,
                    'height' => $item->height,
                    'side' => $item->side,
                    'trafic' => $item->trafic,
                    'image2' => $item->image2,
                    'slug' => $item->slug,
                    'city' => [
                        'id' => $item->city_id,
                        'name' => $item->city_name,
                        'province' => [
                            'id' => $item->province_id,
                            'name' => $item->province_name,
                        ]
                    ],
                    'type' => [
                        'id' => $item->type_id,
                        'name' => $item->type_name,
                        'icon' => $item->type_icon,
                    ]
                ];
            });

            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }
}
