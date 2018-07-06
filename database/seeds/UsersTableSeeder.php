<?php

use App\Api\V1\Domain\User\Entity\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $user = factory(User::class)->make([
            'email' => 'qweasd@qwe.com',
        ]);
        $user->save();
    }
}
