<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.index');
    }

    public function getAll()
    {
        $users = User::select('id_user', 'nama_user', 'username', 'user_priv', 'status')
            ->where('username', '!=', session('user.username')) // Menggecualikan pengguna dengan username sesi
            ->get();


        $data = [];
        $no = 1;

        foreach ($users as $user) {
            $id         = $user->id_user;
            $nama       = $user->nama_user;
            $username   = $user->username;
            $password      = $user->password;
            $priv      = $user->user_priv;
            $alamat       = $user->alamat;
            $hp    = $user->hp;
            $status    = $user->status;
            if ($status === 'aktif') {
                $badge = '<td scope="row"><span class="badge me-1 bg-success">' . $status . '</span></td>';
            } else if ($status === 'tidak aktif') {
                $badge = '<td scope="row"><span class="badge me-1 bg-danger">' . $status . '</span></td>';
            }
            $array = '<tr><td scope="row">' . $no . '</td>';
            $array .= '<td scope="row">' . $nama . '</td>';
            $array .= '<td scope="row">' . $username . '</td>';
            $array .= '<td scope="row">' . $priv . '</td>';
            $array .= $badge;
            $array .= '<td scope="row"> 
            <a class="btn me-2 detail" id="' . $id . '"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
          </svg></a>
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
    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validate([
            'nama_user'   => 'required|string|max:40',
            'username'   => 'required|string|min:4',
            'password'    => 'required|string|min:8',
            'role'    => 'required|string|in:petugas,admin|min:5',
            'alamat'    => 'required|string',
            'hp'          => 'required|numeric|digits_between:12,15',
        ], [
            'nama_user.required' => 'Nama user harus diisi.',
            'nama_user.max' => 'Nama user tidak boleh melebihi 40 karakter.',
            'username.required' => 'Username harus diisi.',
            'username.min' => 'Username minimal 4 karakter.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'role.min' => 'Nilai bidang role harus berupa "petugas" atau "admin".',
            'alamat.required' => 'Alamat harus diisi.',
            'hp.required' => 'Nomor HP harus diisi.',
            'hp.numeric' => 'Nomor HP harus berupa angka.',
            'hp.digits_between' => 'Nomor HP minimal 12 digit.',
        ]);

        $hashedPassword = Hash::make($validatedData['password']);


        $user = User::create([
            'nama_user'   => $validatedData['nama_user'],
            'username'   => $validatedData['username'],
            'password'    => $hashedPassword,
            'user_priv'    => $validatedData['role'],
            'alamat'          => $validatedData['alamat'],
            'hp'          => $validatedData['hp'],
        ]);

        if ($user) {
            $result = [
                "data"  => '',
                "msg"   => "Petugas berhasil ditambahkan"
            ];
            return response()->json($result);
        } else {
            $result = [
                "data"  => '',
                "msg"   => "Petugas gagal ditambahkan"
            ];
            return response()->json($result, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $id)
    {
        $data = User::select('id_user', 'nama_user', 'username', 'user_priv', 'alamat', 'hp', 'status', 'created_at', 'updated_at')->find($id);

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
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $id)
    {
        if ($request->password) {

            $validatedData = $request->validate([
                'nama_user'   => 'required|string|max:40',
                'password'    => 'string|min:8',
                'alamat'    => 'required|string',
                'hp' => 'required|numeric|digits_between:12,15',
                'status'          => 'required',
            ], [
                'nama_user.required' => 'Nama user harus diisi.',
                'nama_user.max' => 'Nama user tidak boleh melebihi 40 karakter.',
                'password.min' => 'Password minimal 8 karakter.',
                'alamat.required' => 'Alamat harus diisi.',
                'hp.required' => 'Nomor HP harus diisi.',
                'hp.numeric' => 'Nomor HP harus berupa angka.',
                'hp.digits_between' => 'Nomor HP harus memiliki antara 12 hingga 15 digit.',
                'status.required' => 'Status harus diisi',
            ]);

            $hashedPassword = Hash::make($validatedData['password']);


            $data = User::where('id_user', $id->id_user)
                ->update([
                    'nama_user' => $validatedData['nama_user'],
                    'password' => $hashedPassword,
                    'alamat' => $validatedData['alamat'],
                    'hp' => $validatedData['hp'],
                    'status' => $validatedData['status'],
                ]);
        } else {
            $validatedData = $request->validate([
                'nama_user'   => 'required|string|max:40',
                'password'    => '',
                'alamat'    => 'required|string',
                'hp'         => 'required|numeric|digits_between:12,15',
                'status'          => 'required',
            ], [
                'nama_user.required' => 'Nama user harus diisi.',
                'nama_user.max' => 'Nama user tidak boleh melebihi 40 karakter.',
                'password.min' => 'Password minimal 8 karakter.',
                'alamat.required' => 'Alamat harus diisi.',
                'hp.required' => 'Nomor HP harus diisi.',
                'hp.numeric' => 'Nomor HP harus berupa angka.',
                'hp.digits_between' => 'Nomor HP harus memiliki antara 12 hingga 15 digit.',
                'status.required' => 'Status harus diisi',
            ]);


            $data = User::where('id_user', $id->id_user)
                ->update([
                    'nama_user' => $validatedData['nama_user'],
                    'alamat' => $validatedData['alamat'],
                    'hp' => $validatedData['hp'],
                    'status' => $validatedData['status'],
                ]);
        }




        if ($data) {
            $result = [
                "data"  => '',
                "msg"   => "Petugas berhasil diubah"
            ];
            return response()->json($result);
        } else {
            $result = [
                "data"  => '',
                "msg"   => 'Petugas gagal diubah'
            ];
            return response()->json($result);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $id)
    {

        if ($id) {
            $id->delete();
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
