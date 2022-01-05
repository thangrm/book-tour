<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('tour_id')->index('tour_id');
            $table->tinyInteger('rate')->comment('Từ 1-5 tương ứng với 1-5 sao');
            $table->text('comment');
            $table->tinyInteger('status')->default(1)->comment('1: active, 2: inactive');
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
        Schema::dropIfExists('reviews');
    }
}
