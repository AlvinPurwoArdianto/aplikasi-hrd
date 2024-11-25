<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama_pegawai' => 'Sample Karyawan',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jl. Contoh, Surabaya',
            'email' => 'sample@gmail.com',
            'password' => Hash::make('1234567890'),
            'tanggal_masuk' => '2022-01-01',
            'gaji' => 5000000,
            'status_pegawai' => 1,
            'is_admin' => 0,
            'google_id' => null,
        ]);

    }
}
