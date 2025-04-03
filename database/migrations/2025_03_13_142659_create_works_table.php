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
        Schema::create('works', function (Blueprint $table) {
            $table->string('WorkID');
            $table->string('Title');
            $table->string('LongTitle');
            $table->string('ShortTitle');
            $table->integer('Date');
            $table->string('GenreType');
            $table->string('Notes');
            $table->string('Source');
            $table->integer('TotalWords');
            $table->integer('TotalParagraphs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
