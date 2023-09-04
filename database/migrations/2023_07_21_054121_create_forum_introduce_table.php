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
        Schema::create("forum_introduce", function (Blueprint $table) {
            $table->id();
            $table->text("objective");
            $table->text("vision");
            $table->text("history_and_purpose");
            $table->text("greetings");
            $table->text("rules");
            $table->string("ci_logo", 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("forum_introduce");
    }
};
