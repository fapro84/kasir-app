<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primary = 'id_pelanggan';
    public $timestamps = false;


    protected $fillable = [
        'nama',
        'alamat',
        'hp',
    ];
}
