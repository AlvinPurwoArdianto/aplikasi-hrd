<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekrutmen extends Model
{
    protected $fillable = ['id', 'nama', 'tanggal_lamaran', 'status_lamaran'];
    public $timestamp = true;
    use HasFactory;
}
