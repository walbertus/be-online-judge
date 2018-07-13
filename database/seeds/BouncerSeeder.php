<?php

use Illuminate\Database\Seeder;
use Silber\Bouncer\Bouncer;

class BouncerSeeder extends Seeder
{
    public function run(Bouncer $bouncer): void
    {
        $problemSetter = $bouncer->role([
            'name' => 'problem-setter',
            'title' => 'Problem setter',
        ]);
        $problemSetter->save();
    }
}
