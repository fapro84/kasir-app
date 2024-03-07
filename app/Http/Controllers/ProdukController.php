<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\Produk;

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
    public function store(StoreProdukRequest $request)
    {
        $validatedData = $request->validate([
            'nama_barang'   => 'required|string|max:50',
            'id_kategori'   => 'required|exists:kategori,id_kategori', // Memastikan id_kategori ada dalam tabel kategoris
            'harga_beli'    => 'required|numeric|min:500',
            'harga_jual'    => 'required|numeric|min:500',
            'stok'          => 'required|integer|min:1',
            'barcode'       => 'required|numeric',
        ], [
            'nama_barang.required' => 'Nama Barang tidak boleh kosong',
            'nama_barang.max' => 'Nama Barang maksimal 50 karakter',
            'id_kategori.reqired' => 'Kategori tidak boleh kosong',
            'id_kategori.exists' => 'Kategori tidak tersedia',
            'harga_beli.required' => 'Harga beli tidak boleh kosong',
            'harga_beli.numeric' => 'Harga beli harus angka',
            'harga_beli.min' => 'Harga beli minimal Rp.500',
            'harga_jual.required' => 'Harga jual tidak boleh kosong',
            'harga_jual.numeric' => 'Harga jual harus angka',
            'harga_jual.min' => 'Harga jual minimal Rp.500',
            'stok.required' => 'Stok tidak boleh kosong',
            'stok.int' => 'Stok harus angka',
            'stok.min' => 'Stok minimal harus 1',
            'barcode.required' => 'Barcode tidak boleh kosong',
            'barcode.numeric' => 'Barcode maksimal 20 angka',
            // 'barcode.max' => 'Barcode maksimal 20 angka',
        ]);

        $barcode = $validatedData['barcode'];
        $existingBarcode = Produk::where('barcode', $barcode)->exists();
        if ($existingBarcode) {
            $result = [
                "msg"   => "Barcode sudah ada, periksa lagi",
            ];
            return response()->json($result, 422);
        }

        $produk = Produk::create([
            'nama_produk'   => $validatedData['nama_barang'],
            'id_kategori'   => $validatedData['id_kategori'],
            'harga_beli'    => $validatedData['harga_beli'],
            'harga_jual'    => $validatedData['harga_jual'],
            'stok'          => $validatedData['stok'],
            'barcode'       => $validatedData['barcode'],
        ]);

        if ($produk) {
            $result = [
                "data"  => '',
                "msg"   => "Produk berhasil ditambahkan"
            ];
            return response()->json($result);
        } else {
            $result = [
                "data"  => '',
                "msg"   => "Produk gagal ditambahkan"
            ];
            return response()->json($result, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $id)
    {
        $data = Produk::find($id)->first();

        if ($data) {
            $result = [
                "data"  => $data,
                "msg"   => ""
            ];
        } else {
            $result = [
                "data"  => $data,
                "msg"   => "Data tidak ditemukan"
            ];
        }


        return response()->json($result);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdukRequest $request, Produk $id)
    {
        $data = Produk::where('id_produk', $id->id_produk)
            ->update([
                'nama_produk' => $request->nama_barang,
                'id_kategori' => $request->id_kategori,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual,
                'stok' => $request->stok,
                'barcode' => $request->barcode,
            ]);



        if ($data) {
            $result = [
                "data"  => '',
                "msg"   => "Produk berhasil diubah"
            ];
            return response()->json($result);
        } else {
            $result = [
                "data"  => '',
                "msg"   => "Produk gagal diubah"
            ];
            return response()->json($result, 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);

        if ($produk) {
            $produk->delete();
            $result = [
                "data"  => "",
                "msg"   => "Data Berhasil dihapus"
            ];
            return $result;
        } else {
            $result = [
                "data"  => "",
                "msg"   => "Data tidak ditemukan"
            ];
            return $result;
        }
    }
}
