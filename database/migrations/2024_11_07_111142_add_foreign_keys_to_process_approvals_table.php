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
        Schema::table('process_approvals', function (Blueprint $table) {
            $table->foreign(['process_approval_flow_step_id'])->references(['id'])->on('process_approval_flow_steps')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('process_approvals', function (Blueprint $table) {
            $table->dropForeign('process_approvals_process_approval_flow_step_id_foreign');
            $table->dropForeign('process_approvals_user_id_foreign');
        });
    }
};
