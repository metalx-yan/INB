<?php

use Illuminate\Database\Seeder;
use App\Models\SubMenu;

class SubMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loops = ['query balance', 'query upload'];
            
            foreach ($loops as $loop) {
                Submenu::create([
                    'name' => $loop,
                    'permission_id' => 2,
                    'slug' => Str::slug($loop)
                ]);
            }
        
        $loops = ['saldo posisi', 'saldo average'];
            
            foreach ($loops as $loop) {
                Submenu::create([
                    'name' => $loop,
                    'permission_id' => 3,
                    'slug' => Str::slug($loop)
                ]);
            }
    }
}
