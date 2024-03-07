@extends('layouts.master')
@section('content')
    <div class="body flex-grow-1 px-3">

        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-3">
                    <div class="card-header">Cari Barang</div>
                    <div class="card-body">
                        <form id="searchbrg">
                            <div id="reader" width="300px"></div>
                            <input type="number" class="form-control mt-3" name="search" placeholder="Masukkan kode barang"
                                aria-label="Harga" required>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-3">
                    <div class="card-header">Hasil Pencarian</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="search_data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8">
                <div class="card mb-3">
                    <div class="card-header">Detail Transaksi</div>
                    <div class="card-body">
                        <p>Tanggal: <span id="current-datetime"></span></p>

                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped mb-4">
                                <thead>
                                    <tr>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="listData"></tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card mb-3">
                    <div class="card-header">Pembayaran</div>
                    <div class="card-body">
                        <div>
                            <h2>Total</h2>
                            <h2 id="total"></h2>
                        </div>
                        <div class="mb-3">
                            <label for="bayar" class="col-sm-5 col-form-label">Bayar</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="bayar">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="pelanggan" class="col-sm-5 col-form-label">Pelanggan</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="pelanggan">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="kembalian" class="col-sm-5 col-form-label">Kembalian</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" name="kembalian">
                            </div>
                        </div>

                        <div class="mb-3">
                            <div>
                                <button type="button" class="btn btn-primary bayar">Bayar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script>
            // Get the element where the date and time will be displayed
            const currentDatetimeElement = document.getElementById("current-datetime");

            // Function to update the date and time
            function updateDatetime() {
                const now = new Date();
                const formattedDatetime = now.toLocaleString('id-ID', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: 'numeric',
                    minute: 'numeric',
                    second: 'numeric',
                }); // Adjust format as needed
                currentDatetimeElement.textContent = formattedDatetime;
            }

            // Update the date and time initially
            updateDatetime();

            // Set interval to update the date and time every second
            setInterval(updateDatetime, 1000);
        </script>


    </div>
@endsection

@section('request')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        #cameraSelection {
            display: none;
        }
    </style>
    <script>
        $("#sbtrafns").addClass("active");
        $("#breadcrumb").text("Penjualan");
        $('input[name=total]').val('');
        $('input[name=kembalian]').val('');
        $('input[name=search]').val('');
        $('input[name=pelanggan]').val('');
        $('input[name=total]').prop('disabled', 'true');
        $('input[name=kembalian]').prop('disabled', 'true');

        $(document).ready(function() {
            var bayar = $('input[name=bayar]').val('');
            var total = $('#total').text('');
            scanBarcode();
            $('#searchbrg input[name=search]').keypress(function(e) {
                if (e.which == 13) {
                    e.preventDefault(); // Mencegah form dari pengiriman default
                    var barcode = $('input[name=search]').val();; // Mengambil nilai ID barang dari input

                    // Mengirim permintaan AJAX
                    $.ajax({
                        url: '/penjualan/' + barcode, // Ganti URL dengan endpoint yang sesuai
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.data) {
                                $('#search_data').html('');
                                // Menampilkan nama barang dalam elemen dengan id "nama_barang"
                                dataProduk = response.data;
                                var dt =
                                    `<tr><td> ${dataProduk.nama_produk} </td> <td>${dataProduk.harga_jual}</td>  <td><input name="qty" type="number" required></td> <td><button class="btn btn-info add" id="${dataProduk.id_produk}">add</button></td></tr>`;

                                $('#search_data').html(dt);
                                $('input[name=search]').val('');
                            } else {
                                $('#tbody-data').html('');
                                $('input[name=search]').val('');
                                Swal.fire({
                                    title: 'Peringatan',
                                    text: 'Barang tidak ada',
                                    icon: 'warning'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            $(document).on('click', '.add', function() {
                // var id = $(this).attr('id');
                var id = dataProduk.id_produk;
                var nama = dataProduk.nama_produk;
                var harga = dataProduk.harga_jual;
                var qty = $('input[name=qty]').val();
                var sub_total = harga * qty;
                var inp_total = $('#total').text();

                var dt = `<tr>
                            <td class="d-none">${id}</td>
                            <td>${nama}</td>
                            <td>${harga}</td>
                            <td>${qty}</td>
                            <td>${sub_total}</td>
                          </tr>`;

                if (qty) {
                    $('#listData').append(dt);
                    var total = +inp_total + +sub_total;
                    $('#total').text(total);
                    $('#search_data').html('');
                    console.log(total);
                    scanBarcode();
                } else {
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Jangan lupa isi Qty barang',
                        icon: 'warning'
                    });

                }
            });

            $(document).on('keyup', 'input[name=bayar]', function() {
                var bayar = $(this).val();
                var total = $('#total').text();
                var kembalian = bayar - total;
                format = formatRupiah(kembalian);
                $('input[name=kembalian]').val(kembalian);
            });


            $(document).on('click', '.bayar', function() {
                // Array untuk menyimpan data barang dari tabel
                var listProduk = [];

                // Mendapatkan setiap baris dalam tabel
                $('#listData tr').each(function(index, row) {
                    // Mengambil nilai dari setiap kolom dalam baris
                    var id = $(row).find('td:eq(0)').text();
                    var nama = $(row).find('td:eq(1)')
                        .text(); // Mengambil nilai dari kolom pertama (indeks 0)
                    var harga = $(row).find('td:eq(2)')
                        .text(); // Mengambil nilai dari kolom kedua (indeks 1)
                    var qty = $(row).find('td:eq(3)')
                        .text(); // Mengambil nilai dari kolom ketiga (indeks 2)
                    var total = $(row).find('td:eq(4)')
                        .text(); // Mengambil nilai dari kolom keempat (indeks 3)

                    // Menambahkan data barang ke dalam array listBarang
                    listProduk.push({
                        id: id,
                        nama: nama,
                        harga: harga,
                        qty: qty,
                        total: total,
                    });

                    console.log(listProduk);
                });

                var bayar = $('input[name=bayar]').val();
                var pelanggan = $('input[name=pelanggan]').val();
                var total = $('#total').text();

                if (bayar) {
                    if (bayar >= total) {
                        $.ajax({
                            url: '/listBarang',
                            type: 'POST',
                            contentType: 'application/json',
                            dataType: 'json',
                            data: JSON.stringify({
                                pelanggan: pelanggan,
                                listProduk: listProduk,
                                bayar: bayar,
                                "_token": "{{ csrf_token() }}"
                            }),

                            success: function(response) {
                                // Proses berhasil
                                if (response.redirect) {
                                    // Redirect pengguna ke URL yang ditentukan
                                    window.location.href = response.redirect;
                                }
                            },
                            error: function(xhr, status, error) {
                                // Terjadi kesalahan
                                console.error(xhr.responseText);
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Bayar kurang',
                            confirmButtonText: 'OK'
                        });
                    }


                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Bayar harus di isi',
                        confirmButtonText: 'OK'
                    });
                }


            });

            function scanBarcode() {
                var html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader", {
                        fps: 10,
                        qrbox: 250
                    });

                function onScanSuccess(decodedText, decodedResult) {
                    // Handle on success condition with the decoded text or result.
                    // alert(`Scan result: ${decodedText}`, decodedResult);
                    // ...

                    // Mengirim permintaan AJAX
                    $.ajax({
                        url: '/penjualan/' + decodedText, // Ganti URL dengan endpoint yang sesuai
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.data) {
                                $('#search_data').html('');
                                // Menampilkan nama barang dalam elemen dengan id "nama_barang"
                                dataProduk = response.data;
                                var dt =
                                    `<tr><td> ${dataProduk.nama_produk} </td> <td>${dataProduk.harga_jual}</td>  <td><input name="qty" type="number" required></td> <td><button class="btn btn-info add" id="${dataProduk.id_produk}">add</button></td></tr>`;

                                $('#search_data').html(dt);
                                $('input[name=search]').val('');
                            } else {
                                $('#tbody-data').html('');
                                Swal.fire({
                                    title: 'Peringatan',
                                    text: 'Barang tidak ada',
                                    icon: 'warning'
                                });
                                scanBarcode();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                    html5QrcodeScanner.clear();
                    // ^ this will stop the scanner (video feed) and clear the scan area.
                }

                html5QrcodeScanner.render(onScanSuccess);
            }

            function formatRupiah(angka) {
                var reverse = angka.toString().split('').reverse().join('');
                var ribuan = reverse.match(/\d{1,3}/g);
                var formatted = ribuan.join('.').split('').reverse().join('');
                return formatted;
            }

        });
    </script>
@endsection
