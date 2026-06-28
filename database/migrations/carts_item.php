<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id(); // BIGINT

            // giỏ hàng chứa nhiều sản phẩm
            $table->foreignId('cart_id')
                  ->constrained('carts')
                  ->cascadeOnDelete();

            // sản phẩm biến thể (màu + size)
            $table->foreignId('product_variant_id')
                  ->constrained('product_variants')
                  ->cascadeOnDelete();

            $table->integer('quantity'); // số lượng

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};