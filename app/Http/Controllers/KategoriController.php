<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kategori.index');
    }

    public function getAll()
    {
        // $kategoris = Kategori::all();
        // $kategoris = Kategori::select('id_kategori', 'nama_kategori')->get();
        $kategoris = Kategori::all();

        $data = [];
        $no = 1;

        foreach ($kategoris as $kategori) {
            $id = $kategori->id_kategori;
            $nama = $kategori->nama_kategori;

            $array = '<tr><td scope="row">' . $no . '</td>';
            $array .= '<td scope="row">' . $id . '</td>';
            $array .= '<td scope="row">' . $nama . '</td>';
            $array .= '<td scope="row"> 
            <a class="btn me-2 update" id="' . $id . '"><svg class="icon"><use xlink:href="' . asset("vendors/@coreui/icons/svg/free.svg#cil-pencil") . '"></use></svg></a>
            <a class="btn  btnDelete" id="' . $id . '"><svg class="icon"><use xlink:href="' . asset("vendors/@coreui/icons/svg/free.svg#cil-trash") . '"> </use></svg></a>
            </td></tr>';
            $data[] = $array;
            $no++;
        }

        if (!$kategoris) {
            $result = [
                'data' => '',
                'msg'  => 'gagal'
            ];

            return response()->json($result);
        }

        $result = [
            'data' => $data,
            'msg'  => ''
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
    public function store(StoreKategoriRequest $request)
    {
        $validateData = $request->validate([
            'id'    => 'required',
            'nama'  => 'required',
        ]);

        $kategori = Kategori::create([
            'id_kategori' => $validateData['id'],
            'nama_kategori' => $validateData['nama'],
        ]);

        if ($kategori) {
            $result = [
                'data'  => '',
                'msg'   => 'Kategori berhasil ditambahkan',
            ];

            return response()->json($result);
        } else {
            $result = [
                'data'  => '',
                'msg'   => 'Kategori gagal ditambahkan',
            ];

            return response()->json($result);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        $data = Kategori::where('id_kategori', $kategori->id_kategori)->first();
        if ($data) {
            $result = [
                'data'  => $data,
                'msg'   => ''
            ];

            return response()->json($result);
        } else {
            $result = [
                'data'  => '',
                'msg'   => 'Data tidak ditemukan'
            ];

            return response()->json($result);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriRequest $request, Kategori $id)
    {
        $data = Kategori::where('id_kategori', $id->id_kategori)
            ->update([
                'id_kategori' => $request->id,
                'nama_kategori' => $request->nama,
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
            return response()->json($result);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $id)
    {
        $kategori = Kategori::find($id->id_kategori);

        if ($kategori) {
            $kategori->delete();
            $result = [
                "data"  => "",
                "msg"   => "Data Berhasil dihapus",
            ];
            return $result;
        } else {
            $result = [
                "data"  => "",
                "msg"   => "Data tidak ditemukan",
            ];
            return $result;
        }
    }

    public function listKategori()
    {
        $kategori = Kategori::all();
        return response()->json($kategori);
    }
}