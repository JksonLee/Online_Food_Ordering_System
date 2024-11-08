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
        Schema::create('deliver_boys', function (Blueprint $table) {
            $table->bigIncrements('delivery_boy_id');
            $table->string('delivery_boy_name');
            $table->string('delivery_boy_phone_number')->unique();
            $table->string('delivery_boy_password');
            $table->integer('delivery_boy_status');
            $table->dateTime('added_on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliver_boys');
    }
};
