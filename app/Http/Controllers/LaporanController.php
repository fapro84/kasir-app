<?php

namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function getAll()
    {
        $penjualans = Penjualan::join('users', 'penjualan.id_user', '=', 'users.id_user')
            ->select('penjualan.id_penjualan', 'users.nama_user', 'penjualan.id_pelanggan', 'penjualan.tanggal_penjualan')
            ->get();

        $data = [];
        $no = 1;

        foreach ($penjualans as $penjualan) {
            $id         = $penjualan->id_penjualan;
            $nama       = $penjualan->nama_user;
            $pelanggan  =  $penjualan->id_pelanggan;
            $tgl        = $penjualan->tanggal_penjualan;

            $array = '<tr><td scope="row">' . $no . '</td>';
            $array .= '<td scope="row">' . $id . '</td>';
            $array .= '<td scope="row">' . $nama . '</td>';
            $array .= '<td scope="row">' . $pelanggan . '</td>';
            $array .= '<td scope="row">' . $tgl . '</td>';
            $array .= '<td scope="row"> 
            <a class="btn me-2 detail" id="' . $id . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
            </svg></a>
            </td></tr>';

            $data[] = $array;
            $no++;
        }

        $result = [
            'data'  => $data,
            'msg'   => ''
        ];

        return response()->json($result);
    }

    public function show(Penjualan $id)
    {
        $penjualan = Penjualan::join('users', 'penjualan.id_user', '=', 'users.id_user')
            ->select('penjualan.id_penjualan', 'users.nama_user', 'penjualan.id_pelanggan', 'total_harga', 'bayar', 'kembalian', 'diskon', 'penjualan.tanggal_penjualan')
            ->find($id);

        $details = DetailPenjualan::where('id_penjualan', $id->id_penjualan)
            ->join('produk', 'detail_penjualan.id_produk', '=', 'produk.id_produk')
            ->select('nama_produk', 'detail_penjualan.harga_jual', 'detail_penjualan.qty', 'detail_penjualan.sub_total')
            ->get();

        $data = [];

        foreach ($details as $detail) {
            $nama       = $detail->nama_produk;
            $harga      = $detail->harga_jual;
            $qty        =  $detail->qty;
            $sub_total  = $detail->sub_total;

            $array = '<tr><td scope="row">' . $nama . '</td>';
            $array .= '<td scope="row">' . $harga . '</td>';
            $array .= '<td scope="row">' . $qty . '</td>';
            $array .= '<td scope="row">' . $sub_total . '</td></tr>';

            $data[] = $array;
        }


        $item = [
            'penjualan' => $penjualan,
            'detail'    => $data,
        ];

        if ($penjualan && $details) {
            $result = [
                "data"  => $item,
                "msg"   => ""
            ];
        } else {
            $result = [
                "data"  => $item,
                "msg"   => "Data tidak ditemukan"
            ];
        }

        return response()->json($result);
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
        // $penjualan = Penjualan::whereBetween('tanggal_penjualan', [$startDate, $endDate]);
        $penjualans = Penjualan::whereBetween('tanggal_penjualan', [$startDate, $endDate])->join('users', 'penjualan.id_user', '=', 'users.id_user')
            ->select('penjualan.id_penjualan', 'users.nama_user', 'penjualan.id_pelanggan', 'penjualan.tanggal_penjualan')
            ->get();

        $data = [];
        $no = 1;

        foreach ($penjualans as $penjualan) {
            $id         = $penjualan->id_penjualan;
            $nama       = $penjualan->nama_user;
            $pelanggan  =  $penjualan->id_pelanggan;
            $tgl        = $penjualan->tanggal_penjualan;

            $array = '<tr><td scope="row">' . $no . '</td>';
            $array .= '<td scope="row">' . $id . '</td>';
            $array .= '<td scope="row">' . $nama . '</td>';
            $array .= '<td scope="row">' . $pelanggan . '</td>';
            $array .= '<td scope="row">' . $tgl . '</td>';
            $array .= '<td scope="row"> 
            <a class="btn me-2 detail" id="' . $id . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
            </svg></a>
            </td></tr>';

            $data[] = $array;
            $no++;
        }

        $result = [
            'data'  => $data,
            'msg'   => ''
        ];

        return response()->json($result);
    }
}
