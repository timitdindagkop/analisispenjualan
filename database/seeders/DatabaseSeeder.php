<?php

namespace Database\Seeders;

use App\Models\Suplier;
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
            'username' => 'owner',
            'password' => bcrypt('owner'),
            'role' => '1',
        ]);

        User::create([
            'id' => intval((microtime(true) * 10000)),
            'name' => 'Karyawan',
            'username' => 'karyawan',
            'password' => bcrypt('karyawan'),
            'role' => '2',
        ]);

        Suplier::create([
            'id' => intval((microtime(true) * 1000)),
            'kode_perusahaan' => 'PHS001',
            'nama_perusahaan' => 'PT Logio AM',
            'alamat' => 'Amerika',
            'telepon' => '0823454332765',
        ]);

        Suplier::create([
            'id' => intval((microtime(true) * 1000)),
            'kode_perusahaan' => 'PHS002',
            'nama_perusahaan' => 'Sinjuku JP',
            'alamat' => 'Jepang',
            'telepon' => '08234543327345',
        ]);
    }
}
