<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    
    protected $fillable = [
        'nama_produk',
        'id_kategori',
        'harga_beli',
        'harga_jual',
        'stok',
        'barcode',
    ];
}