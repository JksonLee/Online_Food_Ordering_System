<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('coupon_id');
            $table->string('coupon_code')->unique();
            $table->integer('coupon_type');
            $table->integer('coupon_value');
            $table->integer('cart_min_value');
            $table->dateTime('expired_on');
            $table->integer('coupon_status');
            $table->dateTime('added_on');
            $table->timestamps();
                   $table->unsignedBigInteger('dish_id'); // Add dish_id column as a foreign key
             $table->foreign('dish_id')->references('dish_id')->on('dishes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
