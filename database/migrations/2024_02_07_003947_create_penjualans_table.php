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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('id_penjualan');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_pelanggan')->nullable();
            $table->decimal('diskon', 8, 2)->nullable();
            $table->decimal('total_harga', 8, 2);
            $table->decimal('bayar', 8, 2);
            $table->decimal('kembalian', 8, 2);
            $table->timestamp('tanggal_penjualan')->default(DB::raw('CURRENT_TIMESTAMP'));

            // Menambahkan foreign key constraint untuk id_user
            $table->foreign('id_user')->references('id_user')->on('users')->onUpdate('cascade');

            // Menambahkan foreign key constraint untuk id_pelanggan
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};