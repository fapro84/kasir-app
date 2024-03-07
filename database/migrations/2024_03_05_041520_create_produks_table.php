<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->bigIncrements('id_produk');
            $table->string('id_kategori', 255);
            $table->string('nama_produk', 255);
            $table->decimal('harga_beli', 8, 2);
            $table->decimal('harga_jual', 8, 2);
            $table->smallInteger('stok');
            $table->string('barcode', 15)->unique();
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
            // $table->foreign('id_kategori')->constrained()->onDelete('cascade'); //lebih simpel

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};