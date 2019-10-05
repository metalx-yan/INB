<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // foreach (App\Models\Region::all() as $reg) {
        //     foreach (App\Models\Level::all() as $lev) {
        //         foreach (App\Models\JobLevel::all() as $job) {
        //             foreach (App\Models\ManagementUnit::all() as $manage) {
                        User::create([
                            'name' => 'administrator',
                            // 'email' => 'aldian@gmail.com',
                            'username' => 'admin',
                            'password' => 'user',
                            'region_id' => 1,
                            'level_id' => 1,
                            'job_level_id' => 1,
                            'management_unit_id' => 1
                        ]);
        //             }
        //         }
        //     }
        // }
    }
}
