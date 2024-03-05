<?php

namespace App\Http\Controllers;

use App\Models\produk;
use App\Http\Requests\StoreprodukRequest;
use App\Http\Requests\UpdateprodukRequest;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produk.index');
    }

    public function getAll()
    {
        $produks = Produk::join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
        ->select('produk.*', 'kategori.nama_kategori')
        ->get();

        $data = [];
        $no = 1;

        foreach ($produks as $produk) {
            $id         = $produk->id_produk;
            $nama       = $produk->nama_produk;
            $kategori   = $produk->nama_kategori;
            $harga_beli      = $produk->harga_beli;
            $harga_jual      = $produk->harga_jual;
            $stok       = $produk->stok;
            $barcode    = $produk->barcode;

            $array = '<tr><td scope="row">' . $no . '</td>';
            $array .= '<td scope="row">' . $nama . '</td>';
            $array .= '<td scope="row">' . $kategori . '</td>';
            $array .= '<td scope="row">' . $harga_beli . '</td>';
            $array .= '<td scope="row">' . $harga_jual . '</td>';
            $array .= '<td scope="row">' . $stok . '</td>';
            $array .= '<td scope="row">' . $barcode . '</td>';
            $array .= '<td scope="row"> 
            <a class="btn me-2 update" id="' . $id . '"><svg class="icon"><use xlink:href="' . asset("vendors/@coreui/icons/svg/free.svg#cil-pencil") . '"></use></svg></a>
            <a class="btn  btnDelete" id="' . $id . '"><svg class="icon"><use xlink:href="' . asset("vendors/@coreui/icons/svg/free.svg#cil-trash") . '"> </use></svg></a>
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
    public function store(StoreprodukRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(produk $id)
    {
        $data = Produk::where('id_produk', $id->id_produk)->first();
        if ($data) {
            $result = [
                "data"  => $data,
                "msg"   => "",
            ];
            return response()->json($result);
        } else {
            $result = [
                "data"  => "",
                "msg"   => "Data tidak ditemukan",
            ];
            return response()->json($result);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateprodukRequest $request, produk $produk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(produk $id)
    {
        $produk = Produk::find($id->id_produk);

        if ($produk) {
            $produk->delete();

            $result = [
                "msg" => "Data berhasil dihapus",
            ];
            return $result;
        } else {
            $result = [
                "msg" => "Data tidak ditemukan",
            ];
        }
    }
}
