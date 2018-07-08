<?php

use App\Api\V1\Domain\User\Entity\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        factory(User::class)->create([
            'email' => 'qweasd@qwe.com',
        ]);
    }
}
