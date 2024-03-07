<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_penjualan', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_penjualan');
            $table->unsignedBigInteger('id_produk');
            $table->decimal('harga_jual', 8, 2);
            $table->integer('qty');
            $table->decimal('sub_total', 8, 2);

            // Menambahkan foreign key constraint untuk id_penjualan
            $table->foreign('id_penjualan')
                ->references('id_penjualan')->on('penjualan')
                ->onDelete('cascade')->onUpdate('cascade');

            // Menambahkan foreign key constraint untuk id_produk
            $table->foreign('id_produk')
                ->references('id_produk')->on('produk')
                ->onDelete('cascade')->onUpdate('cascade');
        });

        // Membuat trigger untuk mengurangi stok produk setelah detail penjualan ditambahkan
        DB::unprepared('
            CREATE TRIGGER `kurangi_stok` AFTER INSERT ON `detail_penjualan` FOR EACH ROW BEGIN
                UPDATE produk
                SET stok = stok - NEW.qty
                WHERE id_produk = NEW.id_produk;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualan');
    }
};