<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Pembeli;
use App\Models\Suplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


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

        Pembeli::create([
            'id' => Str::uuid()->toString(),
            'kode_pembeli' => 1702034803890,
            'nama_pembeli' => "Santi",
            'alamat' => "Pekalaongan",
            'telepon' => "0823261321345"
        ]);

        Pembeli::create([
            'id' => Str::uuid()->toString(),
            'kode_pembeli' => 1752784803574,
            'nama_pembeli' => "Indra",
            'alamat' => "Pekalaongan",
            'telepon' => "0238423642344"
        ]);

        Suplier::create([
            'id' => 1702032971502,
            'kode_perusahaan' => 'TM001',
            'nama_perusahaan' => 'CV. Terus makmur',
            'alamat' => 'Semarang',
            'telepon' => '0823454332765',
        ]);

        Suplier::create([
            'id' => 1702032971504,
            'kode_perusahaan' => 'SAN001',
            'nama_perusahaan' => 'PT. Seger agro nusantara',
            'alamat' => 'Semarang',
            'telepon' => '08234543327345',
        ]);

        Suplier::create([
            'id' => 1785062978236,
            'kode_perusahaan' => 'SJ0001',
            'nama_perusahaan' => 'CV. Sawit Juara',
            'alamat' => 'Semarang',
            'telepon' => '082347352434366',
        ]);

        Barang::create([
            'id' => Str::uuid()->toString(),
            'suplier_id' => 1702032971502,
            'kode_barang' => "CPUT01",
            'nama_barang' => "CPU - Tulip",
            'harga_jual' => 12400,
            'harga_beli' => 11800,
            'stok_barang' => 0,
            'keterangan' => "tes",
        ]);

        Barang::create([
            'id' => Str::uuid()->toString(),
            'suplier_id' => 1702032971504,
            'kode_barang' => "SRG01",
            'nama_barang' => "SSG - SGR",
            'harga_jual' => 12200,
            'harga_beli' => 11900,
            'stok_barang' => 0,
            'keterangan' => "tes",
        ]);
        
        Barang::create([
            'id' => Str::uuid()->toString(),
            'suplier_id' => 1785062978236,
            'kode_barang' => "SPC",
            'nama_barang' => "SPC - Siip",
            'harga_jual' => 12000,
            'harga_beli' => 11600,
            'stok_barang' => 0,
            'keterangan' => "tes",
        ]);
    }
}
