<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nama_pegawai',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'email',
        'tanggal_masuk',
        'umur',
        'gaji',
        'status_pegawai',
        'id_jabatan',
    ];

    public $timestamp = true;

    public function penggajian()
    {
        return $this->hasMany(Penggajian::class);
    }
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    // public function cuti()
    // {
    //     return $this->hasMany(Cutis::class);
    // }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }
}
