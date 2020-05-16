<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->string('id', 32)->primary();
            $table->string('name', 50);
            $table->string('categories_id', 32);
            $table->string('image_path');
            $table->integer('stock');
            $table->decimal('base_price', 10, 2);
            $table->decimal('sale_price', 10, 2);
            $table->timestamps();

            //$table->foreign('categories_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
