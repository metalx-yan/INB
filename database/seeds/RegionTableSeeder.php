<?php

use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loops = ['Jakarta', 'Jogja', 'Madiun'];
        foreach ($loops as $loop) {
            Region::create([
                'name' => $loop,
                'province_id' => 1
            ]);
        }
        
    }
}
