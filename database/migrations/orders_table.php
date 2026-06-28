<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // BIGINT

            // người đặt hàng
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // tổng tiền đơn hàng
            $table->decimal('total', 10, 2);
            $table->text('address');
            
            // trạng thái đơn hàng
            $table->enum('status', [
                'pending',
                'processing',
                'shipping',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->timestamps(); // created_at + updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};