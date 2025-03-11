<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::connection('mysql2')->create('it_outputs', function (Blueprint $table) {
            $table->id();
            $table->string('banfn', 10); // CHAR(10)
            $table->date('badat')->nullable(); // DATS(8)
            $table->string('pr_already', 200)->nullable(); // CHAR(200)
            $table->string('pr_next', 200)->nullable(); // CHAR(200)
            $table->string('ernam', 12)->nullable(); // CHAR(12)
            $table->date('erdat')->nullable(); // DATS(8)
            $table->string('bnfpo', 5); // NUMC(5)
            $table->string('matnr1', 18)->nullable(); // CHAR(18)
            $table->string('txz011', 40)->nullable(); // CHAR(40)
            $table->string('txz02', 200)->nullable(); // CHAR(200)
            $table->decimal('menge1', 13, 3)->nullable(); // QUAN(13)
            $table->string('meins1', 3)->nullable(); // UNIT(3)
            $table->decimal('preis', 13, 2)->nullable(); // CURR(13)
            $table->decimal('total', 13, 2)->nullable(); // CURR(13)
            $table->string('afnam', 12)->nullable(); // CHAR(12)
            $table->string('lifnr', 10)->nullable(); // CHAR(10)
            $table->string('mcod1', 25)->nullable(); // CHAR(25)
            $table->string('ebeln', 10)->nullable(); // CHAR(10)
            $table->date('aedat')->nullable(); // DATS(8)
            $table->string('ebelp', 5)->nullable(); // NUMC(5)
            $table->string('po_already', 200)->nullable(); // CHAR(200)
            $table->string('po_next', 200)->nullable(); // CHAR(200)
            $table->string('matnr2', 18)->nullable(); // CHAR(18)
            $table->string('txz012', 40)->nullable(); // CHAR(40)
            $table->string('loekz', 1)->nullable(); // CHAR(1)
            $table->decimal('menge2', 13, 3)->nullable(); // QUAN(13)
            $table->string('meins2', 3)->nullable(); // UNIT(3)
            $table->decimal('netwr', 15, 2)->nullable(); // CURR(15)
            $table->string('waers', 5)->nullable(); // CUKY(5)
            $table->string('mblnr', 10)->nullable(); // CHAR(10)
            $table->decimal('grjum', 13, 2)->nullable(); // CURR(13)
            $table->decimal('grval', 13, 2)->nullable(); // CURR(13)
            $table->string('belnr', 10)->nullable(); // CHAR(10)
            $table->date('budat')->nullable(); // DATS(8)
            $table->decimal('irjum', 13, 2)->nullable(); // CURR(13)
            $table->decimal('irval', 13, 2)->nullable(); // CURR(13)
            $table->string('ficlear', 4)->nullable(); // NUMC(4)
            $table->decimal('wrbtr', 13, 2)->nullable(); // CURR(13)
            $table->string('shkzg', 1)->nullable(); // CHAR(1)
            $table->string('xblnr', 30)->nullable(); // CHAR(30)
            $table->string('bktxt', 25)->nullable(); // CHAR(25)
            $table->decimal('begrjum', 13, 2)->nullable(); // CURR(13)
            $table->decimal('begrval', 13, 2)->nullable(); // CURR(13)
            $table->decimal('beirjum', 13, 2)->nullable(); // CURR(13)
            $table->decimal('beirval', 13, 2)->nullable(); // CURR(13)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('mysql2')->dropIfExists('it_outputs');
    }
};
