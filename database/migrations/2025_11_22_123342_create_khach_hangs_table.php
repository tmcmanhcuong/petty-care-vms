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
        Schema::create('khach_hangs', function (Blueprint $table) {
            $table->id();
            $table->string('ho_lot');
            $table->string('ten');
            $table->string('email')->unique();
            $table->string('mat_khau');
            $table->string('so_dien_thoai', 10)->nullable();
            $table->string('dia_chi')->nullable();
            $table->string('anh_dai_dien')->nullable();
            $table->string('trang_thai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khach_hangs');
    }
};
