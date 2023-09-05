<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('forum_introduce', function (Blueprint $table) {
      $table->string('chairman_position', 40)->nullable();
      $table->string('chairman_name', 40)->nullable();
      $table->string('chairman_image', 255)->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('forum_introduce', function (Blueprint $table) {
      //
      $table->dropColum('chairman_position');
      $table->dropColum('chairman_name');
      $table->dropColum('chairman_image');
    });
  }
};