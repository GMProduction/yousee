<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert(
            [
                [
                    'name' => 'Item 1',
                    'type' => 0,
                    'address' => 'Jalan Ronggowarsito No.85 Keprabon, Banjarsari',
                    'latitude' => -7.5684,
                    'longitude' => 110.8236,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'Item 2',
                    'type' => 0,
                    'address' => 'Jalan Sugiyopranoto , Kampung Baru, Pasar Kliwon',
                    'latitude' => -7.5678,
                    'longitude' => 110.8272,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'Item 3',
                    'type' => 1,
                    'address' => 'Jalan Sidikoro, Baluwarti, Pasar Kliwon ( di dalam kraton solo )',
                    'latitude' => -7.579,
                    'longitude' => 110.8279,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'Item 4',
                    'type' => 0,
                    'address' => 'Jalan Arief Rahman Hakim , Tegalharjo, Jebres',
                    'latitude' => -7.5619,
                    'longitude' => 110.8348,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'Item 5',
                    'type' => 2,
                    'address' => 'Jalan Kapten Mulyadi No.11 ,  Sudiroprajan, Jebres',
                    'latitude' => -7.5672,
                    'longitude' => 110.8338,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'Item 6',
                    'type' => 3,
                    'address' => 'Jalan Prameswari II No.19, Kedung Lumbu , Pasar Kliwon',
                    'latitude' => -7.5745,
                    'longitude' => 110.8314,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'Items 7',
                    'type' => 0,
                    'address' => 'Jalan Veteran No.89 , Joyosuran, Pasar Kliwon',
                    'latitude' => -7.5836,
                    'longitude' => 110.826,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'Items 8',
                    'type' => 0,
                    'address' => 'Jalan Yos Sudarso No.242 , Kratonan, Serengan',
                    'latitude' => -7.5794,
                    'longitude' => 110.8214,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'Items 9',
                    'type' => 3,
                    'address' => 'Jalan Gatot Subroto No.124 , Jayengan, Serengan',
                    'latitude' => -7.5744,
                    'longitude' => 110.8206,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
                [
                    'name' => 'Items 10',
                    'type' => 2,
                    'address' => 'Jalan Kapten Patimura , Danukusuman, Serengan',
                    'latitude' => -7.5878,
                    'longitude' => 110.8184,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
