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
        Schema::table('committee_members', function (Blueprint $table) {
            $table->dropForeign(['cId']);
            $table->dropForeign(['id2']);

            $table->unsignedBigInteger('cId')->change();
            $table->unsignedBigInteger('id2')->change();

            $table->foreign('cId')->references('id')->on('committees')->onDelete('CASCADE');
            $table->foreign('id2')->references('id')->on('members')->onDelete('CASCADE');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('committee_members', function (Blueprint $table) {
            $table->dropForeign(['cId']);
            $table->dropForeign(['id2']);

            $table->unsignedBigInteger('cId')->change();
            $table->unsignedBigInteger('id2')->change();
        });
    }
};
