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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // BIGINT

            // khóa ngoai
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();

            $table->string('name'); // tên sản phẩm

            $table->decimal('price', 10, 2); // giá gốc
            $table->decimal('sale_price', 10, 2)->nullable(); // giá khuyến mãi

            $table->text('description')->nullable(); // mô tả

            $table->string('thumbnail'); // ảnh đại diện

            // trạng thái sản phẩm
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};