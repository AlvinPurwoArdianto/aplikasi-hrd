<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Absensi;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Absensi::create(['id_user' => '1' ,'tanggal_absen' => '2024-11-01', 'status' => 'Hadir']);
        Absensi::create(['id_user' => '1' ,'tanggal_absen' => '2024-11-02', 'status' => 'sakit']);
        Absensi::create(['id_user' => '1' ,'tanggal_absen' => '2024-11-03', 'status' => 'Hadir']);
        Absensi::create(['id_user' => '1' ,'tanggal_absen' => '2024-11-04', 'status' => 'sakit']);
        Absensi::create(['id_user' => '1' ,'tanggal_absen' => '2024-11-05', 'status' => 'Hadir']);
    }
}
