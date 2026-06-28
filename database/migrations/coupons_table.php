<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id(); // BIGINT

            // mã giảm giá
            $table->string('code')->unique();

            // giá trị giảm
            $table->integer('discount');

            // loại giảm giá: percent hoặc fixed
            $table->enum('type', ['percent', 'fixed']);

            // thời hạn sử dụng
            $table->dateTime('expires_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};