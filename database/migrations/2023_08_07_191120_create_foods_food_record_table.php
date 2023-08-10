<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodsFoodRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_food_record', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('food_id');
            $table->unsignedBigInteger('food_record_id');
            $table->timestamps();

            // 外部キー制約を追加
            $table->foreign('food_id')->references('id')->on('foods')->onDelete('cascade');
            $table->foreign('food_record_id')->references('id')->on('food_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_food_record');
    }
}
