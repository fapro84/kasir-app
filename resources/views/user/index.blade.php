@extends('layouts.master')

@section('content')
    <div class="body flex-grow-1 px-3">
        {{-- <div class="container-lg"> --}}
        <div class="car"></div>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="">
                    <strong>Kelola Petugas</strong>
                </div>
                <div class="ms-auto">


                    <button type="button" class="btn btn-outline-primary" id="btnAdd" data-coreui-toggle="modal"
                        data-coreui-target="#modalMaster">Tambah Petugas</button>
                </div>
            </div>

            <div class="card-body">
                <div class="example">
                    <div class="tab-content rounded-bottom">
                        <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                            <div class="table-responsive">
                                <table id="myTable" class="table table-striped table-bordered dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-data">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Data-->
        <div class="modal fade" id="modalMaster" tabindex="-1" aria-labelledby="modalMasterLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalMasterLabel">Tambah Petugas</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formTambahPetugas" class="m-3">

                            <input type="hidden" value="add" name="action">
                            <input type="hidden" value="" name="getId">
                            <div class="mb-3 row">
                                <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        aria-label="Nama" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="username" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="username" id="username"
                                        aria-label="Username" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="password" id="password"
                                        aria-label="Password" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="confirmPassword" class="col-sm-3 col-form-label">Konfirmasi
                                    Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="confirmPassword" id="confirmPassword"
                                        aria-label="Confirm Password" required>
                                </div>
                            </div>
                            <div class="mb-3 row d-none" id="alertConfirmasi">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <div class="alert alert-danger" role="alert">
                                        Konfirmasi password tidak sama
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row d-none" id="alert">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <div class="alert alert-warning" role="alert">
                                        kosongkan password jika tidak ingin mengganti
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="role" class="col-sm-3 col-form-label">Role</label>
                                <div class="col-sm-9">
                                    <select class="form-select" id="role" name="role" aria-label="Role"
                                        required>
                                        <option selected disabled value="mstr">Pilih...</option>
                                        <option value="admin">Admin</option>
                                        <option value="petugas">Petugas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control" name="alamat" id="alamat" aria-label="Alamat" required> </textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="hp" class="col-sm-3 col-form-label">No.Hp</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="hp" id="hp"
                                        aria-label="No.Hp" required>
                                </div>
                            </div>



                            <div style="width: 300px; margin: 0 auto;" id="reader"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="btSimpan" form="formTambahPetugas"
                            disabled>Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalMasterLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalMasterLabel">Detail Petugas</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-product" id="userTable">
                                    <tbody>
                                        <tr>
                                            <th width="390">Nama</th>
                                            <td class="nama"></td>
                                        </tr>
                                        <tr>
                                            <th>Username</th>
                                            <td class="username"></td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td class="alamat"></td>
                                        </tr>
                                        <tr>
                                            <th>Hp</th>
                                            <td class="hp"></td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td class="status"></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal buat</th>
                                            <td class="createdAt"></td>
                                        </tr>
                                        <tr>
                                            <th>Terakhir diubah</th>
                                            <td class="updatedAt"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('request')

    <script>
        $("#sbuser").addClass("active");
        $('#breadcrumb').text('Petugas')
        $(function() {

            $(document).on('click', '#btnAdd', function() {
                $('input[name=action]').val('add');
                $('#alert').addClass('d-none');
                $('input[name=nama]').val('');
                $('input[name=username]').val('');
                $('input[name=username]').prop('disabled', false);
                $('input[name=password]').val('');
                $('input[name=confirmPassword]').val('');
                $('select[name=role]').val('mstr');
                $('select[name=role]').prop('disabled', false);
                $('textarea[name=alamat]').val('');
                $('input[name=hp]').val('');


                // Tampilkan modal dengan id "modalMaster"
                $("#modalMaster").modal('show');
            });

            // Menambahkan event listener untuk input password
            $("#password, #confirmPassword").on("input", function() {
                // Mengambil nilai dari kedua input password
                var passwordValue = $("#password").val();
                var confirmPasswordValue = $("#confirmPassword").val();
                // Memeriksa apakah kedua password sama
                if (passwordValue === confirmPasswordValue) {
                    // Jika sama, aktifkan tombol "Simpan"
                    $("#btSimpan").prop("disabled", false);
                    $("#alertConfirmasi").addClass("d-none");
                } else {
                    // Jika tidak sama, nonaktifkan tombol "Simpan"
                    $("#btSimpan").prop("disabled", true);
                    $("#alertConfirmasi").removeClass("d-none");
                }
            });

            $(document).on('click', '.btnDelete', function() {
                var id = $(this).attr('id');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $(this).attr('id');

                        $.ajax({
                            url: `/user/${id}`,
                            type: 'DELETE',
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "id": id
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.msg,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                getIndex();
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Terjadi kesalahan di server: ' +
                                        error,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                });
            });
            $(document).on('click', '.detail', function() {
                var id = $(this).attr('id');
                $("#modalDetail").modal('show');

                $.ajax({
                    url: `/user/${id}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {

                        if (response.data[0].status === 'aktif') {
                            var status =
                                `<span class="badge me-1 bg-success">${response.data[0].status}</span>`;
                        } else {
                            var status =
                                `<span class="badge me-1 bg-danger">${response.data[0].status}</span>`;
                        }

                        $('.nama').html(response.data[0].nama_user);
                        $('.username').text(response.data[0].username);
                        $('.alamat').text(response.data[0].alamat);
                        $('.hp').text(response.data[0].hp);
                        $('.status').html(status);
                        $('.createdAt').text(response.data[0].created_at);
                        $('.updatedAt').text(response.data[0].updated_at);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            })
            $(document).on('click', '.update', function() {
                var id = $(this).attr('id');
                $('#modalMaster').modal('show');
                $('input[name=action]').val('update');
                $('input[name=username]').prop('disabled', true);
                $("#btSimpan").prop("disabled", false);
                $('select[name=role]').prop('disabled', true);
                $("#alertConfirmasi").addClass("d-none");
                $('#alert').removeClass('d-none');
                $('input[name=password]').removeAttr('required');
                $('input[name=confirmPassword]').removeAttr('required');

                $.ajax({
                    url: '/user/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log(response.data[0]);
                        $('input[name=getId]').val(response.data[0].id_user);
                        $('input[name=nama]').val(response.data[0].nama_user);
                        $('input[name=username]').val(response.data[0].username);
                        $('input[name=password]').val('');
                        $('input[name=confirmPassword]').val('');
                        $('select[name=role]').val(response.data[0].user_priv);
                        $('textarea[name=alamat]').val(response.data[0].alamat);
                        $('input[name=hp]').val(response.data[0].hp);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });


            });

            $('#formTambahPetugas').submit(function(event) {
                // Menghentikan perilaku bawaan formulir
                event.preventDefault();

                var action = $('input[name=action]').val();
                var id = $('input[name=getId]').val();

                var formData = {
                    nama_user: $('input[name=nama]').val(),
                    username: $('input[name=username]').val(),
                    password: $('input[name=password]').val(),
                    role: $('select[name=role]').val(),
                    alamat: $('textarea[name=alamat]').val(),
                    hp: $('input[name=hp]').val(),
                    status: 'aktif',
                    _token: '{{ csrf_token() }}',
                };

                if (action === 'add') {
                    $.ajax({
                        url: '/user',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.msg,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });

                            getIndex();
                            $('#modalMaster').modal('hide');

                        },
                        error: function(xhr, status, error) {
                            var response = xhr.responseJSON;
                            if (response && response.errors) {
                                var errorMessage = '';
                                $.each(response.errors, function(key, value) {
                                    errorMessage += value[0] +
                                        '\n'; // Menambahkan pesan kesalahan ke variabel errorMessage
                                });
                                Swal.fire({
                                    title: "Peringatan",
                                    text: errorMessage,
                                    icon: "warning"
                                });
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: "Terjadi kesalahan: " + error,
                                    icon: "error",
                                });
                            }
                        }
                    });
                } else if (action === 'update') {
                    $.ajax({
                        url: '/user/' + id,
                        type: 'PUT',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.msg,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            getIndex();
                            $('#modalMaster').modal('hide');
                        },
                        error: function(xhr, status, error) {
                            var response = xhr.responseJSON;
                            if (response && response.errors) {
                                var errorMessage = '';
                                $.each(response.errors, function(key, value) {
                                    errorMessage += value[0] +
                                        '\n'; // Menambahkan pesan kesalahan ke variabel errorMessage
                                });
                                Swal.fire({
                                    title: "Peringatan",
                                    text: errorMessage,
                                    icon: "warning"
                                });
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: "Terjadi kesalahan: " + error,
                                    icon: "error",
                                });
                            }
                        }
                    });

                }

            });

            getIndex();

            function getIndex() {
                // Mengisi tabel menggunakan data dari Ajax
                $.ajax({
                    url: "/user/getAll",
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $.each(response.data, function(key, values) {
                            $('#tbody-data').html(response.data);
                        });
                        // Inisialisasi DataTables setelah mengisi data
                        $('#myTable').DataTable();
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Terjadi kesalahan: ' + error,
                            icon: "error"
                        });
                    }
                });
            }

        });
    </script>
@endsection
