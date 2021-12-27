<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('type_id')->nullable()->index('type_id');
            $table->integer('destination_id')->nullable()->index('destination_id');
            $table->string('name', 50)->unique();
            $table->string('slug', 50);
            $table->string('image', 100);
            $table->string('paronamic_image', 100)->nullable();
            $table->string('video', 100)->nullable();
            $table->float('price', 10, 0);
            $table->tinyInteger('duration')->comment('1 đơn vị tương ứng v');
            $table->text('overview')->nullable();
            $table->text('included')->nullable();
            $table->text('additional')->nullable();
            $table->text('departure')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: active, 0: inactive');
            $table->tinyInteger('trending')->default(1)->comment('1: active, 0: inactive');
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
        Schema::dropIfExists('tours');
    }
}
