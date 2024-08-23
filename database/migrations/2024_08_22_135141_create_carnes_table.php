<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carnes', function (Blueprint $table) {
            $table->id();
            $table->float('valor_total');
            $table->integer('qtd_parcelas');
            $table->date('data_primeiro_vencimento');
            $table->enum('periodicidade', ['mensal', 'semanal']);
            $table->float('valor_entrada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carnes');
    }
};
