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
            $table->dropColumn('note');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->string('note', 255)->default('일반 회원')->comment('포럼 전체에서의 직위');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('note');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->string('note', 255)->nullable()->comment('일반 회원');
        });
    }
};
