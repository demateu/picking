<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            //specify when using MySQL
            $table->engine = 'InnoDB';    
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->timestamps();

            $table->set('estado_pedido', 
                ['pago aceptado', 'preparacion en proceso', 'pago rechazado', 'enviado'])->default('preparacion en proceso');
            //$table->float('total')->unsigned();

            //FK
            $table->bigInteger('direccion_id')->unsigned();
            $table->foreign('direccion_id')->references('id')->on('direccions');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            Schema::dropIfExists('pedidos');
        });
    }
}