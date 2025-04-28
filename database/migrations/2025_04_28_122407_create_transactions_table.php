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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('merchant_ref');
            $table->string('reference');
            $table->decimal('amount', 15, 2);
            $table->decimal('fee_merchant', 15, 2);
            $table->decimal('fee_customer', 15, 2);
            $table->decimal('total_fee', 15, 2);
            $table->decimal('amount_received', 15, 2);
            $table->string('payment_method');
            $table->string('payment_url');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
