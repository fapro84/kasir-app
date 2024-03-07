<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $primaryKey = 'id_penjualan';

    public $timestamps = false;


    protected $fillable = [
        'id_penjualan',
        'id_user',
        'id_pelanggan',
        'diskon',
        'total_harga',
        'bayar',
        'kembalian',
        'tanggal_penjualan',
    ];
}