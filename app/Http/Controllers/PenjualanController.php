<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;
use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePenjualanRequest $request)
    {
        $penjualan = Penjualan::create([
            'id_user' => session('user.id_user'),
            'id_pelanggan' => $request->pelanggan,
            'diskon' => 0,
            'total_harga' => 0,
            'bayar' => 0,
            'kembalian' => 0,
            'tanggal_penjualan' => now(),
        ]);
        
            
        if (!$penjualan) {
            $result = [
                "data"  => '',
                "msg"   => "gagal membuat transaksi"
            ];
            return response()->json($result, 500);
        }

        $listProduk = $request->listProduk;

        foreach ($listProduk as $produk) {
            $produkFind = Produk::find($produk['id']);
            if ($produkFind->stok < $produk['qty']) {
                // Jika stok tidak mencukupi, batalkan penjualan
                $penjualan->delete();
                $result = [
                    "data"  => '',
                    "msg"   => "Stok " .$produkFind->nama_produk ." tidak mencukupi"
                ];
                return response()->json($result, 500);
            }
            // dd('haloo');

            $detailPenjualan = DetailPenjualan::create([
                'id_penjualan' => $penjualan->id_penjualan, // Ambil ID transaksi baru
                'id_produk' => $produk['id'],
                'harga_jual' => $produk['harga'],
                'qty' => $produk['qty'],
                'sub_total' => $produk['total'],
            ]);

            if (!$detailPenjualan) {
                $penjualan->delete();
                $result = [
                    "data"  => '',
                    "msg"   => "gagal menambah detail transaksi"
                ];
                return response()->json($result, 500);
            }
        }

        $bayar = $request->bayar;

        $totalHarga = DetailPenjualan::where('id_penjualan', $penjualan->id_penjualan)->sum('sub_total');
        $penjualan->total_harga = $totalHarga;
        $penjualan->bayar = $bayar;
        $penjualan->kembalian = $bayar - $totalHarga;
        $penjualan->save();


        if ($penjualan->wasRecentlyCreated || $penjualan->wasChanged()) {

            $invoiceRoute = route('penjualan.invoice', ['id' => $penjualan->id_penjualan]);

            // Mengarahkan pengguna ke halaman invoice transaksi
            return response()->json(['redirect' => $invoiceRoute]);
        } else {
            $result = [
                "data"  => '',
                "msg"   => "Transaksi gagal. Penyimpanan data tidak berhasil."
            ];
            return response()->json($result, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenjualanRequest $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penjualan $penjualan)
    {
        //
    }

    public function getProdukByBarcode($barcode)
    {
        $produk = Produk::where('barcode', $barcode)->first();

        if ($produk) {
            $result = [
                "data"  => $produk,
                "msg"   => ""
            ];
        } else {
            $result = [
                "data"  => null,
                "msg"   => "Barang tidak ditemukan"
            ];
        }

        return response()->json($result);
    }


    public function invoice($id_penjualan)
    {
        $dataPenjualan = Penjualan::where('id_penjualan', $id_penjualan)->first();
        $detail = DetailPenjualan::where('id_penjualan', $id_penjualan)
            ->join('produk', 'detail_penjualan.id_produk', '=', 'produk.id_produk')
            ->select('produk.nama_produk', 'detail_penjualan.harga_jual', 'detail_penjualan.qty', 'detail_penjualan.sub_total')
            ->get();


        // dd($detail->nama_produk);
        $data = [
            'penjualan' => $dataPenjualan,
            'detailPenjualan' => $detail,
        ];

        $result = [
            "data"  => $data,
            "msg"   => "Transaksi berhasil"
        ];
        // $penjualan = Penjualan::findOrFail($id_penjualan);


        return view('nota.index', [
            'penjualan' => $dataPenjualan,
            'detailPenjualan' => $detail,
        ]);
    }
}