<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cutis extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pegawai',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
    ];

    public $timestamp = true;

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai');
    }
}
