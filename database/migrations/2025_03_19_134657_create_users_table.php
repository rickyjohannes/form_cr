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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_code');
            $table->string('npk');
            $table->string('name');
            $table->string('username', 20)->unique();
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('departement');
            $table->string('user_status');
            $table->string('ext_phone')->nullable();
            $table->string('signature_image')->nullable();
            $table->unsignedBigInteger('role_id')->default(3)->index('users_role_id_foreign');
            $table->rememberToken();
            $table->timestamps();
            $table->string('api_token', 80)->nullable()->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
