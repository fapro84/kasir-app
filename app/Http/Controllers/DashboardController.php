<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
    }

    public function getByRange(Request $request)
    {

        $startDate = Carbon::parse($request->startDate)->startOfDay();
        $endDate = Carbon::parse($request->endDate)->endOfDay();

        // Jika startDate sama dengan endDate (hanya satu tanggal yang dipilih)
        if ($startDate == $endDate) {
            // Set startDate ke awal hari
            $startDate = date('Y-m-d 00:00:00');

            // Set endDate ke akhir hari
            $endDate = date('Y-m-d 23:59:59');
        }
// return response()->json($endDate);
        $count = Penjualan::whereBetween('tanggal_penjualan', [$startDate, $endDate])->count();
        $jual = Penjualan::whereBetween('tanggal_penjualan', [$startDate, $endDate])->sum('total_harga');
        $beli  = Penjualan::whereBetween('tanggal_penjualan', [$startDate, $endDate])
            ->join('detail_penjualan', 'penjualan.id_penjualan', '=', 'detail_penjualan.id_penjualan')
            ->join('produk', 'detail_penjualan.id_produk', '=', 'produk.id_produk')
            ->select(DB::raw('SUM(produk.harga_beli * detail_penjualan.qty) as total_harga'))
            ->first()->total_harga;

        $laba = $jual - $beli;

        $result = [
            'count' => $count,
            'jual'  => 'Rp ' . number_format($jual, 0, ',', '.'),
            'laba'  => 'Rp ' . number_format($laba, 0, ',', '.'),
        ];

        return response()->json($result);
    }
}
