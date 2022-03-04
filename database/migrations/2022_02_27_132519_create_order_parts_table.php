<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_parts', function (Blueprint $table) {
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('part_id')->unsigned();
            $table->integer('quantity');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('part_id')->references('id')->on('parts');
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
        Schema::dropIfExists('order_parts');
    }
}
