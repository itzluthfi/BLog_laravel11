<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('landscape_image')->nullable();
            $table->string('portrait_image')->nullable();
            $table->text('description');
            $table->text('full_content');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade'); 
            $table->date('published_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};