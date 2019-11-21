<?php

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        
        foreach (App\Models\Region::all() as $region) {
            # code...
            for ($i=0; $i < 5; $i++) { 
                Branch::create([
                    'code' => $faker->buildingNumber,
                    'name' => $faker->citySuffix,
                    'region_id' => $region->id
                    ]);
                }
        }
    }
}
