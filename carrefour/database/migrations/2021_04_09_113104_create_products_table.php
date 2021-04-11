<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('codigo')->unique();
            $table->string('titulo');
            $table->integer('id_categoria')->unsigned();
            $table->foreign('id_categoria')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('id_subcategoria')->unsigned();
            $table->foreign('id_subcategoria')->references('id')->on('sub_categories')->onDelete('cascade')->onUpdate('cascade');
            $table->text('descricao');
            $table->binary('imagem');
            $table->double('valor');
            $table->string('tag');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
