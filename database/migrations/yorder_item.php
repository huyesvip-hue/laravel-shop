<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // BIGINT

            // đơn hàng chứa nhiều sản phẩm
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete();

            // sản phẩm biến thể
            $table->foreignId('product_variant_id')
                  ->constrained('product_variants')
                  ->cascadeOnDelete();
            $table->string('product_name'); // tên sản phẩm lúc mua
            $table->string('product_image')->nullable(); // ảnh lúc mua
            $table->integer('quantity'); // số lượng

            $table->decimal('price', 10, 2); // giá tại thời điểm mua

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};