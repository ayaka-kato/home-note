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
            $table->integer('food_id')->unsigned()->index();
            $table->string('ideal-amount');
            $table->integer('real-amount')->length(1);
            $table->integer('waste-amount')->length(1);
            $table->string('restock-amount');
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
