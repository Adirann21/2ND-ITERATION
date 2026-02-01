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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('building')->nullable();
            $table->string('room_number')->nullable();
            $table->enum('type', ['classroom', 'laboratory', 'conference_room', 'auditorium', 'sports_hall', 'study_room', 'other'])->default('classroom');
            $table->integer('capacity');
            $table->text('description')->nullable();
            $table->text('amenities')->nullable(); // JSON array of amenities
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_approval')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
