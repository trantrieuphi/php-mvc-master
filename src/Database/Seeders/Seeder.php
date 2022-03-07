<?php

namespace Src\Database\Seeders;

use Src\Models\User;

final class Seeder {
    public function __construct()
    {
        /**
         * create Database here
         */
        User::create([
            'username' => 'tester',
            'password' => '123'
        ]);
    }
}