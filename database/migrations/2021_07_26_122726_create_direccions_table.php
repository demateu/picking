<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDireccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direccions', function (Blueprint $table) {
            //specify when using MySQL
            $table->engine = 'InnoDB';    
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            //$table->timestamps();

            $table->string('nombre');
            $table->string('apellidos');
            $table->string('direccion');
            $table->string('pais');
            //$table->integer('telefono');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('direccions', function (Blueprint $table) {
            Schema::dropIfExists('direccions');
        });
    }
}
