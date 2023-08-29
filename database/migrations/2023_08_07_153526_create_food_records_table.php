<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_records', function (Blueprint $table) {
            $table->id();
            $table->integer('date_id')->unsigned()->index();
            $table->integer('order')->unsigned()->index()->length(2);
            $table->string('color', 10)->nullable();
            $table->string('ingredient', 20);
            $table->string('ideal_amount',50)->nullable();
            $table->integer('real_amount')->length(1)->nullable();
            $table->integer('waste_amount')->length(1)->nullable();
            $table->string('restock_amount',50)->nullable();
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
        Schema::dropIfExists('food_records');
    }
}
