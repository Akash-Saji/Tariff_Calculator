<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tariff;

class TariffSeeder extends Seeder
{
    public function run()
    {
        $tariffs = [
            ['slab_start' => 0, 'slab_end' => 50, 'rate' => 2.80, 'type' => 'telescopic'],
            ['slab_start' => 51, 'slab_end' => 100, 'rate' => 3.20, 'type' => 'telescopic'],
            ['slab_start' => 101, 'slab_end' => 150, 'rate' => 4.20, 'type' => 'telescopic'],
            ['slab_start' => 151, 'slab_end' => 200, 'rate' => 5.80, 'type' => 'telescopic'],
            ['slab_start' => 201, 'slab_end' => null, 'rate' => 7.00, 'type' => 'telescopic'],
            ['slab_start' => 0, 'slab_end' => null, 'rate' => 5.00, 'type' => 'non-telescopic'],
        ];

        foreach ($tariffs as $tariff) {
            Tariff::create($tariff);
        }
    }
}
