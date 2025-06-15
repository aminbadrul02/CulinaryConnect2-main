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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');// just to be mentioned :  Laravel assumes that the column name follows a convention based on the relationship it represents
            $table->string('name');
            $table->string('image_path');
            $table->text('ingredients');
            $table->text('instructions');
            $table->integer('cooking_time');
            $table->enum('difficulty', ['Easy', 'Medium', 'Hard']);
            $table->string('cuisine_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
