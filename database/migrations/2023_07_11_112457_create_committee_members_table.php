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
        Schema::create('committee_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cId');
            $table->unsignedBigInteger('id2');
            $table->string('note', 255)->nullable()->comment('위원회 직위');

            $table->foreign('cId')->references('id')->on('committees');
            $table->foreign('id2')->references('id')->on('members');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committee_members');
    }
};
