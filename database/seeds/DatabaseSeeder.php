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
        // $this->call(UsersTableSeeder::class);
        $this->call(RightSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(SideTypeSeeder::class);
    }
}
