<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;
    
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id_penjualan',
        'id_produk',
        'harga_jual',
        'qty',
        'sub_total'      
    ];
}