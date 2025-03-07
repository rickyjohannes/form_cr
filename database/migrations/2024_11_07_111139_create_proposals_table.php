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
        Schema::create('proposals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_transaksi', 50);
            $table->unsignedBigInteger('user_id')->index('proposals_user_id_foreign');
            $table->string('it_user')->nullable();
            $table->string('user_request');
            $table->string('user_status');
            $table->string('departement');
            $table->string('ext_phone', 50);
            $table->string('status_barang', 50);
            $table->string('kategori');
            $table->string('facility');
            $table->string('user_note')->nullable();
            $table->string('no_asset_user')->nullable();
            $table->timestamp('estimated_date')->nullable();
            $table->string('it_analys')->nullable();
            $table->string('file')->nullable();
            $table->string('file_it')->nullable();
            $table->string('no_asset')->nullable();
            $table->enum('status_dh', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('actiondate_dh')->nullable();
            $table->enum('status_divh', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('actiondate_divh')->nullable();
            $table->string('status_cr')->nullable();
            $table->timestamp('close_date')->nullable();
            $table->string('token')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('last_notified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
