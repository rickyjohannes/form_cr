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
        Schema::create('monitoring_stock', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_barang');
            $table->string('spesifikasi_barang');
            $table->string('barcode');
            $table->integer('status_transaksi')->nullable()->default(0);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_stock');
    }
};
