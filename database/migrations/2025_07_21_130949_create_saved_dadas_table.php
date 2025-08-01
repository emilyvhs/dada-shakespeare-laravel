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
        Schema::create('saved_dadas', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('first_play');
            $table->string('shuffle');
            $table->string('remove_character')->nullable();
            $table->string('second_play')->nullable();
            $table->string('add_character')->nullable();
            $table->string('paragraphs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_dadas');
    }
};
