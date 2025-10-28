<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->createMany([
            [
                'name' => 'Ibu Kabalai',
                'email' => 'kabalai@gmail.com',
                'phone' => '081187651238',
                'role' => '4',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'Verifikator Echa',
                'email' => 'verif@gmail.com',
                'phone' => '081187651237',
                'role' => '2',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'Operator SMA',
                'email' => 'operator@gmail.com',
                'phone' => '081187651235',
                'role' => '2',
                'password' => bcrypt('12345678'),
            ],
            [
                'name' => 'Administrator Echa',
                'email' => 'admin@gmail.com',
                'phone' => '081187651234',
                'role' => '1',
                'password' => bcrypt('12345678'),
            ],

        ]);
    }
}
