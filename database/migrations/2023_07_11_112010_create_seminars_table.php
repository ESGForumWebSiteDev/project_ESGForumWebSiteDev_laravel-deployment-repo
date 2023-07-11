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
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
            $table->string('location', 255)->nullable();
            $table->string('subject', 255)->nullable();
            $table->string('host', 255)->nullable();
            $table->string('supervision', 255)->nullable();
            $table->text('participation')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminars');
    }
};
