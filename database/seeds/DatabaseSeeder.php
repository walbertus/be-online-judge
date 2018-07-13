<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(BouncerSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
