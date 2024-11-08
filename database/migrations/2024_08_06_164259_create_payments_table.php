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
       Schema::create('payments', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->integer('order_id');
        $table->string('payment_type');
        $table->string('order_status')->default('pending');
        $table->timestamps();
  
        // Foreign key constraints
        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
    });
    }

    
    
    /**
     * 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
