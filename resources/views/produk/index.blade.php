   @extends('layouts.master')

   @section('content')
       <div class="body flex-grow-1 px-3">
           {{-- <div class="container-lg"> --}}
           <div class="car"></div>
           <div class="card mb-4">
               <div class="card-header d-flex justify-content-between align-items-center">
                   <div class="">
                       <strong>Produk</strong>
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
                               <div class="table-responsive">
                                   <table id="myTable" class="table table-striped table-bordered dataTable no-footer">
                                       <thead>
                                           <tr>
                                               <th scope="col">No</th>
                                               <th scope="col">Nama</th>
                                               <th scope="col">Kategori</th>
                                               <th scope="col">Harga Beli</th>
                                               <th scope="col">Harga Jual</th>
                                               <th scope="col">Stok</th>
                                               <th scope="col">Barcode</th>
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
                               <div class=" mb-3">
                                   <input type="text" class="form-control" name="nama_produk" placeholder="Nama"
                                       aria-label="Nama Produk" required>
                               </div>
                               <div class=" mb-3">
                                   <select class="form-select" id="kategori" name="id_kategori" aria-label="Kategori"
                                       required>
                                       {{-- <option selected disabled value="mstr">Kategori</option>
                                    <option value="1">Makanan</option>
                                    <option value="2">Barang</option>
                                    <option value="3">Mandi</option> --}}
                                   </select>
                               </div>
                               <div class=" mb-3">
                                   <input type="number" class="form-control" name="harga_beli" placeholder="Harga Beli"
                                       aria-label="Harga Beli" required>
                               </div>
                               <div class=" mb-3">
                                   <input type="number" class="form-control" name="harga_jual" placeholder="Harga Jual"
                                       aria-label="Harga Jual" required>
                               </div>
                               <div class=" mb-3">
                                   <input type="number" class="form-control" name="stok" placeholder="Stok"
                                       aria-label="Stok" required>
                               </div>
                               <div class="mb-3 row g-3 align-items-center">
                                   <div class="col-auto">
                                       <label for="barcode" class="col-form-label">Barcode</label>
                                   </div>
                                   <div class="col-auto">
                                       <div class="input-group">
                                           <input type="number" class="form-control" name="barcode" placeholder="Barcode"
                                               aria-label="Barcode" required>
                                           <button type="button" class="btn btn-warning" id="btn-scanner">
                                               <svg class="nav-icon" height="22" width="32">
                                                   <use
                                                       xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-camera') }}">
                                                   </use>
                                               </svg>
                                           </button>
                                       </div>
                                   </div>
                               </div>

                               <div style="width: 300px; margin: 0 auto;" id="reader"></div>
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
       <script src="https://unpkg.com/html5-qrcode"></script>

       <script>
           $("#sbproduk").addClass("active");
           $("#breadcrumb").text("Produk");

           $(function() {

               $(document).on('click', '#btnAdd', function() {
                   $('input[name=action]').val('add');
                   $('input[name=nama_produk]').val('');
                   $('select[name=id_kategori]').val('mstr');
                   $('input[name=harga_beli]').val('');
                   $('input[name=harga_jual]').val('');
                   $('input[name=stok]').val('');
                   $('input[name=barcode]').val('');


                   // Tampilkan modal dengan id "modalMaster"
                   $("#modalMaster").modal('show');
               });

               $(document).on('click', '.btnDelete', function() {
                   if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                       var id = $(this).attr('id');

                       $.ajax({
                           url: "/produk/" + id,
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
                       url: '/produk/' + id,
                       type: 'GET',
                       dataType: 'json',
                       success: function(response) {
                           // Isi formulir dengan data yang diterima
                           console.log(response.data);
                           $('input[name=getId]').val(response.data.id_produk);
                           $('input[name=nama_produk]').val(response.data.nama_produk);
                           $('select[name=id_kategori]').val(response.data.id_kategori);
                           $('input[name=harga_beli]').val(response.data.harga_beli);
                           $('input[name=harga_jual]').val(response.data.harga_jual);
                           $('input[name=stok]').val(response.data.stok);
                           $('input[name=barcode]').val(response.data.barcode);
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

               $(document).on('click', '#btn-scanner', function() {
                   var html5QrcodeScanner = new Html5QrcodeScanner(
                       "reader", {
                           fps: 10,
                           qrbox: 250
                       });

                   function onScanSuccess(decodedText, decodedResult) {
                       // Handle on success condition with the decoded text or result.
                       // alert(`Scan result: ${decodedText}`, decodedResult);
                       $('input[name=barcode]').val(decodedText);

                       // ...

                       // Mengirim permintaan AJAX

                       html5QrcodeScanner.clear();
                       // ^ this will stop the scanner (video feed) and clear the scan area.
                   }

                   html5QrcodeScanner.render(onScanSuccess);

               });




               $('#formTambahBarang').submit(function(event) {
                   // Menghentikan perilaku bawaan formulir
                   event.preventDefault();

                   var action = $('input[name=action]').val();
                   var id = $('input[name=getId]').val();

                   console.log(id);

                   // Mendapatkan data dari formulir
                   var formData = {
                       nama_barang: $('input[name=nama_produk]').val(),
                       id_kategori: $('select[name=id_kategori]').val(),
                       harga_beli: $('input[name=harga_beli]').val(),
                       harga_jual: $('input[name=harga_jual]').val(),
                       stok: $('input[name=stok]').val(),
                       barcode: $('input[name=barcode]').val(),
                       _token: '{{ csrf_token() }}' // Menambahkan token CSRF
                   };

                   // Permintaan AJAX untuk menyimpan data
                   if (action === 'add') {
                       $.ajax({
                           url: '/produk',
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
                               var response = xhr.responseJSON;

                               if (response && response.msg) {
                                   alert(response.msg);
                               } else {
                                   alert('Terjadi kesalahan: ' + error);
                               }
                           }
                       });
                   } else if (action === 'update') {
                       $.ajax({
                           url: '/produk/' + id,
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
               listKategori();

               function getIndex() {
                   // Mengisi tabel menggunakan data dari Ajax
                   $.ajax({
                       url: "/produk/getAll",
                       type: 'GET',
                       dataType: 'json',
                       success: function(response) {
                           $.each(response.data, function(key, values) {
                               $('#tbody-data').html(response.data);
                           });
                           // Inisialisasi DataTables setelah mengisi data
                           $('#myTable').DataTable().destroy();
                           $('#myTable').DataTable();
                       },
                       error: function(xhr, status, error) {
                           alert('Terjadi kesalahan: ' + error);
                       }
                   });
               }

               function listKategori() {
                   $.ajax({
                       url: '/kategori/list',
                       type: 'GET',
                       dataType: 'json',
                       success: function(response) {
                           if (response.length > 0) {
                               var opt = '<option selected disabled value="mstr">Pilih Kategori</option>';
                               for (i = 0; i < response.length; i++) {
                                   console.log(response[i].id_kategori);

                                   opt += '<option value="' + response[i].id_kategori + '">' + response[i]
                                       .nama_kategori + '</option>';
                               }
                               $("#kategori").html(opt);
                           } else {
                               alert("Tidak ada kategori barang");
                           }
                       },
                       error: function(xhr, status, error) {
                           alert('Terjadi kesalahan: ' + error);
                       }
                   })
               }

           });
       </script>
   @endsection
