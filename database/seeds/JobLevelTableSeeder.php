<?php

use Illuminate\Database\Seeder;
use App\Models\JobLevel;
// use Faker\Factory as Faker;


class JobLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        
        for ($i=0; $i < 5; $i++) { 
            JobLevel::create([
                'name' => $faker->jobTitle
            ]);
        }
    }
}
