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
        Schema::table('lich_hens', function (Blueprint $table) {
            $table->string('nguon_goc', 100)->nullable()->after('trang_thai')->comment('Nguồn gốc đặt lịch (online, phone, walk-in, etc.)');
            $table->dateTime('thoi_gian_checkin')->nullable()->after('nguon_goc')->comment('Thời gian khách hàng check-in');
            $table->dateTime('thoi_gian_bat_dau_kham')->nullable()->after('thoi_gian_checkin')->comment('Thời gian bắt đầu khám');
            $table->dateTime('thoi_gian_hoan_thanh')->nullable()->after('thoi_gian_bat_dau_kham')->comment('Thời gian hoàn thành khám');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lich_hens', function (Blueprint $table) {
            $table->dropColumn(['nguon_goc', 'thoi_gian_checkin', 'thoi_gian_bat_dau_kham', 'thoi_gian_hoan_thanh']);
        });
    }
};
