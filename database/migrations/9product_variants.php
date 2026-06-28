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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id(); // BIGINT

            // liên kết sản phẩm
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->cascadeOnDelete();

            // liên kết màu sắc
            $table->foreignId('color_id')
                  ->constrained('colors')
                  ->cascadeOnDelete();

            // liên kết size
            $table->foreignId('size_id')
                  ->constrained('sizes')
                  ->cascadeOnDelete();

            $table->integer('stock')->default(0); // số lượng tồn kho

            $table->decimal('price_adjust', 10, 2)->default(0); // điều chỉnh giá

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};