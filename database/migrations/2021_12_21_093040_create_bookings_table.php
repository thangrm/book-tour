<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('tour_id')->nullable()->index('tour_id');
            $table->integer('customer_id')->nullable()->index('customer_id');
            $table->float('price', 10, 0);
            $table->mediumInteger('people');
            $table->tinyInteger('payment_method')->default(0)->comment('0: Cash, 1: CreditCard, 2: Paypal');
            $table->boolean('is_payment')->default(false);
            $table->text('requirement')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0: New, 1: Confirmed, 2: Completed, 3: Cancel');
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
        Schema::dropIfExists('bookings');
    }
}
