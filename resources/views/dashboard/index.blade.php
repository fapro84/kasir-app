@extends('layouts.master')


@section('content')
    <div class="container">
        <div class="card mb-3">
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
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Penjualan</div>
                    <div class="card-body">
                        <h3 id="penjualan"></h3>
                    </div>
                </div>
            </div>


            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Pemasukan</div>
                    <div class="card-body">
                        <h3 id="pemasukan"></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Laba</div>
                    <div class="card-body">
                        <h3 id="laba"></h3>
                    </div>
                </div>
            </div>
        </div>





    </div>
@endsection

@section('request')
    <script>
        $('#sbdashboard').addClass("active");

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

                var startDate = $('#reportrange').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var endDate = $('#reportrange').data('daterangepicker').endDate.format('YYYY-MM-DD');

                $.ajax({
                    url: '/dash/getByRange',
                    type: 'post',
                    data: {
                        startDate: startDate,
                        endDate: endDate,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#penjualan').text(response.count);
                        $('#pemasukan').text(response.jual);
                        $('#laba').text(response.laba);
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
                    monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
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
                    url: '/dash/getByRange',
                    type: 'post',
                    data: {
                        startDate: today,
                        endDate: today,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#penjualan').text(response.count);
                        $('#pemasukan').text(response.jual);
                        $('#laba').text(response.laba);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });

            }
        });
    </script>
@endsection
