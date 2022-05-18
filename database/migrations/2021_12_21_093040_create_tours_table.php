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
            $table->integer('type_id')->index('type_id');
            $table->integer('destination_id')->nullable()->index('destination_id');
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->string('image', 100);
            $table->string('image_seo', 100)->nullable();
            $table->string('meta_title', 100)->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->text('map')->nullable();
            $table->string('panoramic_image', 255)->nullable();
            $table->string('video', 100)->nullable();
            $table->float('price', 10, 0);
            $table->tinyInteger('duration');
            $table->text('overview')->nullable();
            $table->text('included')->nullable();
            $table->text('additional')->nullable();
            $table->text('departure')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: active, 2: inactive');
            $table->tinyInteger('trending')->default(1)->comment('1: active, 2: inactive');
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
