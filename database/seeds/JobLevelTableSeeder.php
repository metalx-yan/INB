<?php

use Illuminate\Database\Seeder;
use App\Models\JobLevel;

class JobLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loops = ['dbma', 'mm', 'aah'];
        foreach ($loops as $loop) {
            JobLevel::create([
                'name' => $loop
            ]);
        }
    }
}
