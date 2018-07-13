<?php

use App\Api\V1\Domain\User\Entity\User;
use Illuminate\Database\Seeder;
use Silber\Bouncer\Bouncer;

class UsersTableSeeder extends Seeder
{
    public function run(Bouncer $bouncer): void
    {
        $user = factory(User::class)->create([
            'email' => 'qweasd@qwe.com',
        ]);
        $bouncer->assign('problem-setter')->to($user);
    }
}
