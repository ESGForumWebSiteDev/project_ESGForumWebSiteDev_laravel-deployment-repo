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
        Schema::create('users', function (Blueprint $table) {
            $table->string('email', 20)->unique();
            $table->string('password', 255);
            $table->string('name', 40);
            $table->string('affiliation', 40);
            $table->integer('authority')->nullable()->comment('null - 승인X, 0 - 사용자, 1 - 관리자');
            $table->primary('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
