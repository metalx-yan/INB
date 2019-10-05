<?php

use Illuminate\Database\Seeder;
use App\Models\ManagementUnit;

class ManagementUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loops = ['as', 'sa', 'ss'];
        foreach ($loops as $loop) {
            ManagementUnit::create([
                'name' => $loop
            ]);
        }
    }
}
