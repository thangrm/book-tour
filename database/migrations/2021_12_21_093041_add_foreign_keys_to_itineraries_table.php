<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToItinerariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itineraries', function (Blueprint $table) {
            $table->foreign(['tour_id'], 'itineraries_ibfk_1')->references(['id'])->on('tours')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('itineraries', function (Blueprint $table) {
            $table->dropForeign('itineraries_ibfk_1');
        });
    }
}
