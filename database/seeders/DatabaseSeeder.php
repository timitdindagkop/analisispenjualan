<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();
        User::create([
            'id' => intval((microtime(true) * 10000)),
            'name' => 'Pemilik',
            'username' => 'p',
            'password' => bcrypt('p'),
            'role' => '1',
        ]);

        User::create([
            'id' => intval((microtime(true) * 10000)),
            'name' => 'Karyawan',
            'username' => 'o',
            'password' => bcrypt('o'),
            'role' => '2',
        ]);
    }
}
