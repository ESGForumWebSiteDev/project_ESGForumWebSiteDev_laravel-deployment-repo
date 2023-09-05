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
        Schema::table('members', function (Blueprint $table) {
            $table->string('password', 255);
            $table->integer('authority')->nullable()->comment('null - 승인X, 0 - 사용자, 1 - 관리자');
            $table->text('refresh_token')->nullable()->afrer('authority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('password');
            $table->dropColumn('authority');
            $table->dropColumn('refresh_token');
        });
    }
};
