<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Http\Requests\StorePelangganRequest;
use App\Http\Requests\UpdatePelangganRequest;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pelanggan.index');
    }

    public function getAll()
    {
        $pelanggans = Pelanggan::select('id_pelanggan', 'nama', 'alamat', 'hp')->get();

        $data = [];
        $no = 1;

        foreach ($pelanggans as $pelanggan) {
            $id         = $pelanggan->id_user;
            $nama       = $pelanggan->nama;
            $alamat   = $pelanggan->alamat;
            $hp    = $pelanggan->hp;
            

            $array = '<tr><td scope="row">' . $no . '</td>';
            $array .= '<td scope="row">' . $nama . '</td>';
            $array .= '<td scope="row">' . $alamat . '</td>';
            $array .= '<td scope="row">' . $hp . '</td>';
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
    public function store(StorePelangganRequest $request)
    {
        $validateData = $request->validate([
            'nama'  => 'required',
            'alamat'    => 'required',
            'hp'    => 'required|numeric|',
        ],[
            'nama.required' => 'Nama tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'hp.required' => 'Hp tidak boleh kosong',
        ]);

        $pelanggan = Pelanggan::create([
            'nama' => $validateData['nama'],
            'alamat' => $validateData['alamat'],
            'hp' => $validateData['hp'],
        ]);

        if ($pelanggan) {
            $result = [
                'data'  => '',
                'msg'   => 'Pelanggan berhasil ditambahkan',
            ];

            return response()->json($result);
        } else {
            $result = [
                'data'  => '',
                'msg'   => 'Pelanggan gagal ditambahkan',
            ];

            return response()->json($result);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePelangganRequest $request, Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        //
    }
}
