<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::connection('mysql2')->create('it_outputs', function (Blueprint $table) {
            $table->id();
            $table->string('banfn', 20);
            $table->date('badat')->nullable();
            $table->text('pr_already')->nullable();
            $table->text('pr_next')->nullable();
            $table->string('ernam', 50)->nullable();
            $table->date('erdat')->nullable();
            $table->string('bnfpo', 10);
            $table->string('matnr1', 50)->nullable();
            $table->text('txz011')->nullable();
            $table->text('txz02')->nullable();
            $table->decimal('menge1', 10, 3)->nullable();
            $table->string('meins1', 10)->nullable();
            $table->decimal('preis', 15, 2)->nullable();
            $table->decimal('total', 15, 2)->nullable();
            $table->string('afnam', 100)->nullable();
            $table->string('lifnr', 50)->nullable();
            $table->string('mcod1', 100)->nullable();
            $table->string('ebeln', 20)->nullable();
            $table->date('aedat')->nullable();
            $table->string('ebelp', 10)->nullable();
            $table->text('po_already')->nullable();
            $table->text('po_next')->nullable();
            $table->string('matnr2', 50)->nullable();
            $table->text('txz012')->nullable();
            $table->string('loekz', 10)->nullable();
            $table->decimal('menge2', 10, 3)->nullable();
            $table->string('meins2', 10)->nullable();
            $table->decimal('netwr', 15, 2)->nullable();
            $table->string('waers', 5)->nullable();
            $table->string('mblnr', 20)->nullable();
            $table->decimal('grjum', 15, 2)->nullable();
            $table->decimal('grval', 15, 2)->nullable();
            $table->string('belnr', 20)->nullable();
            $table->date('budat')->nullable();
            $table->decimal('irjum', 15, 2)->nullable();
            $table->decimal('irval', 15, 2)->nullable();
            $table->string('ficlear', 10)->nullable();
            $table->decimal('wrbtr', 15, 2)->nullable();
            $table->string('shkzg', 5)->nullable();
            $table->string('xblnr', 20)->nullable();
            $table->text('bktxt')->nullable();
            $table->decimal('begrjum', 15, 2)->nullable();
            $table->decimal('begrval', 15, 2)->nullable();
            $table->decimal('beirjum', 15, 2)->nullable();
            $table->decimal('beirval', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('it_outputs');
    }
};
