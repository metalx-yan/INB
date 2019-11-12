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
        $codes = ['WKJ', 'WYG', 'WMD'];
        $names = ['Jakarta', 'Jogja', 'Madiun'];
        foreach (array_combine($codes, $names) as $code => $name) {
                Region::create([
                    'name' => $name,
                    'code' => $code
                ]);
        }
        
    }
}
