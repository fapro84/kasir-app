@extends('layouts.master')

@section('content')
    <div class="body flex-grow-1 px-3">
        {{-- <div class="container-lg"> --}}
        <div class="car"></div>
        <div class="card mb-4 mt-2">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="">
                    <strong>Pelanggan</strong>
                </div>
                <div class="ms-auto">


                    <button type="button" class="btn btn-outline-primary" id="btnAdd" data-coreui-toggle="modal"
                        data-coreui-target="#modalMaster">Tambah Pelanggan</button>
                </div>
            </div>

            <div class="card-body">
                <div class="example">
                    <div class="tab-content rounded-bottom">
                        <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                            <table id="myTable" class="table table-striped table-bordered dataTable no-footer">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Hp</th>
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
        <!-- Modal -->
        <div class="modal fade" id="modalMaster" tabindex="-1" aria-labelledby="modalMasterLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalMasterLabel">Tambah Pelanggan</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formTambahBarang">

                            <input type="hidden" value="add" name="action">
                            <input type="hidden" value="" name="getId">
                            <div class="mb-3 row">
                                <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama" aria-label="nama" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="alamat" aria-label="alamat" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="hp" class="col-sm-3 col-form-label">Hp</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="hp" aria-label="hp" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" form="formTambahBarang">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('request')
    <script>
        $("#sbpelanggan").addClass("active");
        $("#breadcrumb").text("Pelanggan");

        $(function() {

            $(document).on('click', '#btnAdd', function() {
                $('input[name=action]').val('add');
                $('input[name=nama]').val('');
                $('input[name=alamat]').val('');
                $('input[name=hp]').val('');

                // Tampilkan modal dengan id "modalMaster"
                $("#modalMaster").modal('show');
            });

            $(document).on('click', '.btnDelete', function() {
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
                            url: "/pelanggan/" + id,
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

            $(document).on('click', '.update', function() {
                var id = $(this).attr('id');
                $('#modalMaster').modal('show');
                $('input[name=action]').val('update');

                // Fungsi untuk mendapatkan data yang akan diedit
                // function getDataToEdit(id) {
                $.ajax({
                    url: '/pelanggan/getById/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Isi formulir dengan data yang diterima
                        $('input[name=getId]').val(response.data.id_pelanggan);
                        $('input[name=nama]').val(response.data.nama);
                        $('input[name=alamat]').val(response.data.alamat);
                        $('input[name=hp]').val(response.data.hp);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });

                // Panggil fungsi untuk mendapatkan data saat modal ditampilkan
                // $('#modalMaster').on('shown.bs.modal', function() {
                //     getDataToEdit(id); // Panggil fungsi dengan ID yang sesuai
                // });
            });

            $('#formTambahBarang').submit(function(event) {
                // Menghentikan perilaku bawaan formulir
                event.preventDefault();

                var action = $('input[name=action]').val();
                var id = $('input[name=getId]').val();

                console.log(id);

                // Mendapatkan data dari formulir
                var formData = {
                    nama: $('input[name=nama]').val(),
                    alamat: $('input[name=alamat]').val(),
                    hp: $('input[name=hp]').val(),
                    _token: '{{ csrf_token() }}' // Menambahkan token CSRF
                };

                // Permintaan AJAX untuk menyimpan data
                if (action === 'add') {
                    $.ajax({
                        url: '/pelanggan',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            // Memeriksa jika respons memiliki pesan sukses
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
                        url: '/pelanggan/' + id,
                        type: 'PUT',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.msg,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                });
                                getIndex();
                                $('#modalMaster').modal('hide');
                            } else {
                                Swal.fire({
                                    title: 'Peringatan',
                                    text: response.msg,
                                    icon: 'warning',
                                    confirmButtonText: 'OK'
                                });
                            }



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
                    url: "/pelanggan/getAll",
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
                            title: 'Terjadi Kesalahan',
                            text: 'Terjadi kesalahan: ' + error,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }

        });
    </script>
@endsection
