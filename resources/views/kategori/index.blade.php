@extends('layouts.master')

@section('content')
    <div class="body flex-grow-1 px-3">
        {{-- <div class="container-lg"> --}}
        <div class="car"></div>
        <div class="card mb-4 mt-2">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="">
                    <strong>Kategori</strong>
                </div>
                <div class="ms-auto">


                    <button type="button" class="btn btn-outline-primary" id="btnAdd" data-coreui-toggle="modal"
                        data-coreui-target="#modalMaster">Tambah Barang</button>
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
                                        <th scope="col">Id Kategori</th>
                                        <th scope="col">Nama Kategori</th>
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
                        <h5 class="modal-title" id="modalMasterLabel">Tambah Barang</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formTambahBarang">

                            <input type="hidden" value="add" name="action">
                            <input type="hidden" value="" name="getId">
                            <div class="mb-3 row">
                                <label for="hp" class="col-sm-3 col-form-label">Id Kategori</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="id_kategori" aria-label="Id Kategori"
                                        required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="hp" class="col-sm-3 col-form-label">Nama Kategori</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nama_kategori"
                                        aria-label="Nama Kategori" required>
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
        $("#sbkategori").addClass("active");
        $("#breadcrumb").text("Kategori");

        $(function() {

            $(document).on('click', '#btnAdd', function() {
                $('input[name=action]').val('add');
                $('input[name=id_kategori]').val('');
                $('input[name=nama_kategori]').val('');


                // Tampilkan modal dengan id "modalMaster"
                $("#modalMaster").modal('show');
            });

            $(document).on('click', '.btnDelete', function() {
                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    var id = $(this).attr('id');

                    $.ajax({
                        url: "/kategori/" + id,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id
                        },
                        success: function(response) {
                            alert(response.msg);
                            getIndex();
                        },
                        error: function(xhr, status, error) {
                            alert('Terjadi kesalahan diserver: ' + error);
                        }
                    });
                }
            });

            $(document).on('click', '.update', function() {
                var id = $(this).attr('id');
                $('#modalMaster').modal('show');
                $('input[name=action]').val('update');

                // Fungsi untuk mendapatkan data yang akan diedit
                // function getDataToEdit(id) {
                $.ajax({
                    url: '/kategori/getById/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Isi formulir dengan data yang diterima
                        $('input[name=getId]').val(response.data.id_kategori);
                        $('input[name=id_kategori]').val(response.data.id_kategori);
                        $('input[name=nama_kategori]').val(response.data.nama_kategori);
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
                    id: $('input[name=id_kategori]').val(),
                    nama: $('input[name=nama_kategori]').val(),
                    _token: '{{ csrf_token() }}' // Menambahkan token CSRF
                };

                // Permintaan AJAX untuk menyimpan data
                if (action === 'add') {
                    $.ajax({
                        url: '/kategori',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            // Memeriksa jika respons memiliki pesan sukses
                            alert(response.msg);

                            getIndex();
                            $('#modalMaster').modal('hide');

                        },
                        error: function(xhr, status, error) {
                            alert('Terjadi kesalahan: ' + error);
                        }
                    });
                } else if (action === 'update') {
                    $.ajax({
                        url: '/kategori/' + id,
                        type: 'PUT',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            alert(response.msg);
                            getIndex();
                            $('#modalMaster').modal('hide');
                        },
                        error: function(xhr, status, error) {
                            alert('Terjadi kesalahan: ' + error);
                        }
                    });

                }

            });

            getIndex();

            function getIndex() {
                // Mengisi tabel menggunakan data dari Ajax
                $.ajax({
                    url: "/kategori/getAll",
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
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            }


        });
    </script>
@endsection
