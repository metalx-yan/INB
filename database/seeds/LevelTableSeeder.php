<?php

use Illuminate\Database\Seeder;
use App\Models\Level;


class LevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loops = ['admin', 'user', 'manager'];
        foreach ($loops as $loop) {
            Level::create([
                'name' => $loop
            ]);
        }
    }
}
