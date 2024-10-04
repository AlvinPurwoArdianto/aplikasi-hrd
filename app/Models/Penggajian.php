<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'id_pegawai', 'tanggal_gaji', 'jumlah_gaji', 'bonus', 'potongan'];
    public $timestamp = true;

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
