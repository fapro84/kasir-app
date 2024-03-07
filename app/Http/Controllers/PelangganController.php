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
            $id         = $pelanggan->id_pelanggan;
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
            'hp'    => 'required|numeric|digits_between:12,15',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'hp.required' => 'Hp tidak boleh kosong',
            'hp.digits_between' => 'Nomor HP minimal 12 digit.',
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
    public function show(Pelanggan $id)
    {
        $data = Pelanggan::where('id_pelanggan', $id->id_pelanggan)->first();
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
    public function edit(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePelangganRequest $request, Pelanggan $id)
    {
        $validateData = $request->validate([
            'nama'  => 'required',
            'alamat'    => 'required',
            'hp'    => 'required|numeric|digits_between:12,15',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'hp.required' => 'Hp tidak boleh kosong',
            'hp.digits_between' => 'Nomor HP minimal 12 digit.',
        ]);

        $data = Pelanggan::where('id_pelanggan', $id->id_pelanggan)
            ->update([
                'nama' => $validateData['nama'],
                'alamat' => $validateData['alamat'],
                'hp' => $validateData['hp'],
            ]);

        if ($data) {
            $result = [
                "msg"       => "Pelanggan berhasil diubah",
                "status"    => true
            ];
            return response()->json($result);
        } else {
            $result = [
                "msg"   => "Anda belum mengubah data",
                "status"    => false
            ];
            return response()->json($result);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $id)
    {
        $pelanggan = Pelanggan::find($id->id_pelanggan);

        if ($pelanggan) {
            $pelanggan->delete();
            $result = [
                "status" => true,
                "msg"   => "Data Berhasil dihapus",
            ];
        } else {
            $result = [
                "msg"   => "Data tidak ditemukan",
            ];
        }

        return response()->json($result);
    }
}
