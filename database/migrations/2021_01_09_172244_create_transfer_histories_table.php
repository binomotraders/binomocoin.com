<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('transferred_by');
            $table->bigInteger('transferred_to');
            $table->double('transferred_coin')->default(0);
            $table->double('price_per_coin')->default(0);
            $table->double('total_price')->default(0);
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
        Schema::dropIfExists('transfer_histories');
    }
}
