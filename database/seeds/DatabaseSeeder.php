<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(ProvincesTableSeeder::class);
        $this->call(RegionTableSeeder::class);
        $this->call(JobLevelTableSeeder::class);
        $this->call(LevelTableSeeder::class);
        $this->call(ManagementUnitTableSeeder::class);
        // $this->call(ParentTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(TypeProductTableSeeder::class);
        $this->call(BranchTableSeeder::class);
        $this->call(AccTypeTableSeeder::class);
    }
}
