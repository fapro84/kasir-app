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
                           data-coreui-target="#modalMaster">Tambah Produk</button>
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
                               <div class="mb-3 row">
                                   <label class="col-sm-3 col-form-label">Nama Produk</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" name="nama_produk" placeholder="Nama"
                                           aria-label="Nama Produk" required>
                                   </div>
                               </div>
                               <div class="mb-3 row">
                                   <label class="col-sm-3 col-form-label">Kategori</label>
                                   <div class="col-sm-9">
                                       <select class="form-select" id="kategori" name="id_kategori" aria-label="Kategori"
                                           required></select>
                                   </div>
                               </div>
                               <div class="mb-3 row">
                                   <label class="col-sm-3 col-form-label">Harga Beli</label>
                                   <div class="col-sm-9">
                                       <input type="number" class="form-control" name="harga_beli" placeholder="Harga Beli"
                                           aria-label="Harga Beli" step="any" required>
                                   </div>
                               </div>
                               <div class="mb-3 row">
                                   <label class="col-sm-3 col-form-label">Harga Jual</label>
                                   <div class="col-sm-9">
                                       <input type="number" class="form-control" name="harga_jual" placeholder="Harga Jual"
                                           aria-label="Harga Jual" step="any" required>
                                   </div>
                               </div>
                               <div class="mb-3 row">
                                   <label class="col-sm-3 col-form-label">Stok</label>
                                   <div class="col-sm-9">
                                       <input type="number" class="form-control" name="stok" placeholder="Stok"
                                           aria-label="Stok" required>
                                   </div>
                               </div>
                               <div class="mb-3 row">
                                   <label class="col-sm-3 col-form-label">Barcode</label>
                                   <div class="col-sm-9">
                                       <div class="col-auto">
                                           <div class="input-group">
                                               <input type="number" class="form-control" name="barcode"
                                                   placeholder="Barcode" aria-label="Barcode" required>
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
                               url: "/produk/" + id,
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
                       url: '/produk/' + id,
                       type: 'GET',
                       dataType: 'json',
                       success: function(response) {
                           // Isi formulir dengan data yang diterima
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
                       if (/^\d+$/.test(decodedText)) {
                           // Jika decodedText berisi angka, set nilai input "barcode"
                           $('input[name=barcode]').val(decodedText);
                       } else {
                           // Jika decodedText bukan angka, tampilkan SweetAlert
                           Swal.fire({
                               title: 'Peringatan!',
                               text: 'Barcode harus berupa angka.',
                               icon: 'warning',
                               confirmButtonText: 'OK'
                           });
                       }

                       html5QrcodeScanner.clear();
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
                               response = xhr.responseJSON;
                               if (response && response.errors) {
                                   var errorMessage = '';
                                   $.each(response.errors, function(key, value) {
                                       errorMessage += value[0] +
                                           '\n'; // Menambahkan pesan kesalahan ke variabel errorMessage
                                       Swal.fire({
                                           title: errorMessage,
                                           icon: "warning"
                                       });
                                   });

                               } else {
                                   Swal.fire({
                                       title: 'Terjadi kesalahan: ' + response.msg,
                                       icon: "error"
                                   });
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
                               Swal.fire({
                                   title: 'Error',
                                   text: 'Terjadi kesalahan diserver: ' + error,
                                   icon: 'success',
                                   confirmButtonText: 'OK'
                               });
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
                           $('#myTable').DataTable();
                       },
                       error: function(xhr, status, error) {
                           Swal.fire({
                               title: 'Error',
                               text: 'Terjadi kesalahan diserver saat memunculkan data: ' + error,
                               icon: 'error',
                               confirmButtonText: 'OK'
                           });
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
                                   opt += '<option value="' + response[i].id_kategori + '">' + response[i]
                                       .nama_kategori + '</option>';
                               }
                               $("#kategori").html(opt);
                           } else {
                               Swal.fire({
                                   title: 'Peringatan',
                                   text: 'Tidak ada kategori barang: ' + error,
                                   icon: 'warning',
                                   confirmButtonText: 'OK'
                               });
                           }
                       },
                       error: function(xhr, status, error) {
                           Swal.fire({
                               title: 'Error',
                               text: 'Terjadi kesalahan saat mengambil data kategori: ' + error,
                               icon: 'error',
                               confirmButtonText: 'OK'
                           });
                       }
                   })
               }

           });
       </script>
   @endsection
