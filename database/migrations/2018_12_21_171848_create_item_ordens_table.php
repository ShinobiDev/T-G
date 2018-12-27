<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemOrdensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_ordens', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('orden_id');
            $table->unsignedInteger('item_id')->nullable();
            $table->unsignedInteger('estadoItem_id');
            $table->unsignedInteger('sede_id');
            $table->string('marca');
            $table->string('referencia');
            $table->string('descripcion');
            $table->string('cantidad');
            $table->string('comentarios');
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
        Schema::dropIfExists('item_ordens');
    }
}
