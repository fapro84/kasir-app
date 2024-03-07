@extends('layouts.master')

@section('content')
    <div class="body flex-grow-1 px-3">
        {{-- <div class="container-lg"> --}}
        <div class="car"></div>
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="">
                    <strong>Laporan</strong>
                </div>
                <div class="ms-auto">

                </div>
            </div>

            <div class="card-body">
                <div class="mb-3 row">
                    <label class="col-sm-1 col-form-label" for="reportrange">Periode:</label>
                    <div class="col-sm-9">
                        <div class="col-auto">
                            <div class="input-group">
                                <input type="text" id="reportrange" class="ml-2">
                                <span class="input-group-text" id="basic-addon2">
                                    <svg id="basic" class="nav-icon" height="22" width="32">
                                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-calendar') }}">
                                        </use>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="example">
                    <div class="tab-content rounded-bottom">
                        <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                            <div class="table-responsive">
                                <table id="myTable" class="table table-striped table-bordered dataTable no-footer">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Id Penjualan</th>
                                            <th scope="col">Petugas</th>
                                            <th scope="col">Id Pelanggan</th>
                                            <th scope="col">Tanggal</th>
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

        <!-- Modal Detail -->
        <div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalMasterLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalMasterLabel">Detail Penjualan</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-product" id="userTable">
                                    <tbody>
                                        <tr>
                                            <th width="200">Id Penjualan</th>
                                            <td class="id"></td>
                                        </tr>
                                        <tr>
                                            <th>Petugas</th>
                                            <td class="petugas"></td>
                                        </tr>
                                        <tr>
                                            <th>Id Pelanggan</th>
                                            <td class="pelanggan"></td>
                                        </tr>
                                        <tr>
                                            <th>Total Harga</th>
                                            <td class="total"></td>
                                        </tr>
                                        <tr>
                                            <th>Bayar</th>
                                            <td class="bayar"></td>
                                        </tr>
                                        <tr>
                                            <th>Kembalian</th>
                                            <td class="kembalian"></td>
                                        </tr>
                                        <tr>
                                            <th>Diskon</th>
                                            <td class="diskon"></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal</th>
                                            <td class="tgl"></td>
                                        </tr>
                                        <!-- Tabel Detail Barang -->
                                        <tr>
                                            <th colspan="2">Detail Produk</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <table class="table table-striped mt-2">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Produk</th>
                                                            <th>Harga</th>
                                                            <th>Qty</th>
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="detail-produk">

                                                        <!-- Isi tabel detail barang akan di-generate secara dinamis menggunakan JavaScript -->
                                                    </tbody>
                                                </table>
                                            </td>
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
        $('#breadcrumb').text('Laporan')
        $(function() {

            $(document).on('click', '.detail', function() {
                var id = $(this).attr('id');
                $("#modalDetail").modal('show');

                $.ajax({
                    url: `/laporan/${id}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('.id').text(response.data.penjualan[0].id_penjualan);
                        $('.petugas').text(response.data.penjualan[0].nama_user);
                        $('.pelanggan').text(response.data.penjualan[0].id_pelanggan);
                        $('.total').text(response.data.penjualan[0].total_harga);
                        $('.bayar').text(response.data.penjualan[0].bayar);
                        $('.kembalian').text(response.data.penjualan[0].kembalian);
                        $('.diskon').text(response.data.penjualan[0].diskon);
                        $('.tgl').text(response.data.penjualan[0].tanggal_penjualan);
                        $('#detail-produk').html(response.data.detail);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            })

            $(document).ready(function() {
                getRangeToday();

                // Mendapatkan tanggal hari ini
                var today = moment();

                // Callback untuk menampilkan tanggal yang dipilih
                function cb(start, end) {
                    var label = '';

                    // Jika rentang tanggal sama dengan hari ini
                    if (start.isSame(today) && end.isSame(today)) {
                        label = 'Hari Ini';
                    } else {
                        label = start.format('YYYY MMMM DD') + ' ~ ' + end.format('YYYY MMMM DD');
                    }

                    // Tampilkan label di dalam input
                    // $('#reportrange span').html(label);

                    // Setel nilai input sesuai dengan rentang tanggal yang dipilih
                    $('#reportrange').val(label);

                    var startDate = $('#reportrange').data('daterangepicker').startDate.format(
                        'YYYY-MM-DD');
                    var endDate = $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');

                    $.ajax({
                        url: '/laporan/getByRange',
                        type: 'post',
                        data: {
                            startDate: startDate,
                            endDate: endDate,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#tbody-data').html(response.data);
                            $('#myTable').DataTable();
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }

                // Membuat date range picker dengan rentang tanggal hari ini
                $('#reportrange').daterangepicker({
                    startDate: today,
                    endDate: today,
                    locale: {
                        format: 'YYYY-MM-DD',
                        separator: '    ~    ',
                        applyLabel: 'Terapkan',
                        cancelLabel: 'Batal',
                        fromLabel: 'Dari',
                        toLabel: 'Hingga',
                        customRangeLabel: 'Rentang Kustom',
                        daysOfWeek: ['Mg', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],
                        monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                            'Agustus',
                            'September', 'Oktober', 'November', 'Desember'
                        ],
                        firstDay: 1
                    },
                    ranges: {
                        'Hari Ini': [today, today],
                        '7 Hari Terakhir': [moment().subtract(6, 'days'), today],
                        '15 Hari Terakhir': [moment().subtract(14, 'days'), today],
                        '1 Bulan Terakhir': [moment().subtract(1, 'month'), today]
                    }
                }, cb);

                // Menjalankan callback untuk menampilkan tanggal yang dipilih
                cb(today, today);

                function getRangeToday() {
                    var today = moment().format('YYYY-MM-DD');

                    // Membuat permintaan AJAX untuk data penjualan hari ini
                    $.ajax({
                        url: '/laporan/getByRange',
                        type: 'post',
                        data: {
                            startDate: today,
                            endDate: today,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            $('#tbody-data').html(response.data);
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

            // getIndex();

            // function getIndex() {
            //     // Mengisi tabel menggunakan data dari Ajax
            //     $.ajax({
            //         url: "/laporan/getAll",
            //         type: 'GET',
            //         dataType: 'json',
            //         success: function(response) {
            //             $.each(response.data, function(key, values) {
            //                 $('#tbody-data').html(response.data);
            //             });
            //             // Inisialisasi DataTables setelah mengisi data
            //             $('#myTable').DataTable();
            //         },
            //         error: function(xhr, status, error) {
            //             Swal.fire({
            //                 title: 'Terjadi kesalahan: ' + error,
            //                 icon: "error"
            //             });
            //         }
            //     });
            // }

        });
    </script>
@endsection
