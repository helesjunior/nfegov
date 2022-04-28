<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Heles Junior',
            'email' => 'helesjunior@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$P.4doh27jPGTInpvf7zo8exdwJHYO1Hz3G5hFr9U.2J3yE0XGIHbW', // 123456
            'remember_token' => 'PJw4muvkwK',
        ]);

    }
}
