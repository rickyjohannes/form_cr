<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::connection('mysql2')->create('it_outputs', function (Blueprint $table) {
            $table->id();
            $table->string('banfn', 10);
            $table->date('badat')->nullable();
            $table->string('pr_already', 200)->nullable();
            $table->string('pr_next', 200)->nullable();
            $table->string('ernam', 12)->nullable();
            $table->date('erdat')->nullable();
            $table->string('bnfpo')->nullable();
            $table->string('matnr1', 18)->nullable();
            $table->string('txz011', 40)->nullable();
            $table->string('txz02', 200)->nullable();
            $table->decimal('menge1', 23, 3)->nullable();
            $table->string('meins1', 3)->nullable();
            $table->decimal('preis', 23, 4)->nullable();
            $table->decimal('total', 23, 4)->nullable();
            $table->string('afnam', 12)->nullable();
            $table->string('lifnr', 10)->nullable();
            $table->string('mcod1', 35)->nullable();
            $table->string('ebeln', 10)->nullable();
            $table->date('aedat')->nullable();
            $table->string('ebelp', 5)->nullable();
            $table->string('po_already', 200)->nullable();
            $table->string('po_next', 200)->nullable();
            $table->string('matnr2', 18)->nullable();
            $table->string('txz012', 40)->nullable();
            $table->string('loekz', 1)->nullable();
            $table->decimal('menge2', 23, 3)->nullable();
            $table->string('meins2', 3)->nullable();
            $table->decimal('netwr', 23, 4)->nullable();
            $table->string('waers', 5)->nullable();
            $table->string('mblnr', 10)->nullable();
            $table->decimal('grjum', 23, 4)->nullable();
            $table->decimal('grval', 23, 4)->nullable();
            $table->string('belnr', 10)->nullable();
            $table->date('budat')->nullable();
            $table->decimal('irjum', 23, 4)->nullable();
            $table->decimal('irval', 23, 4)->nullable();
            $table->string('ficlear', 16)->nullable();
            $table->decimal('wrbtr', 23, 4)->nullable();
            $table->string('shkzg', 1)->nullable();
            $table->string('xblnr', 16)->nullable();
            $table->string('bktxt', 25)->nullable();
            $table->decimal('begrjum', 23, 4)->nullable();
            $table->decimal('begrval', 23, 4)->nullable();
            $table->decimal('beirjum', 23, 4)->nullable();
            $table->decimal('beirval', 23, 4)->nullable();
            $table->string('leadtime_pr', 10)->nullable();
            $table->string('status_pr', 20)->nullable();
            $table->string('leadtime_po', 10)->nullable();
            $table->string('status_po', 20)->nullable();
            $table->string('leadtime_prpo', 10)->nullable();
            $table->string('waers_pr', 5)->nullable();
            $table->timestamps();

            // Tambahkan UNIQUE constraint
            $table->unique(['banfn', 'bnfpo', 'ebeln', 'ebelp', 'matnr1'], 'unique_banfn_bnfpo_ebeln_ebelp_matnr1');
        });
    }

    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('it_outputs');
    }
};
