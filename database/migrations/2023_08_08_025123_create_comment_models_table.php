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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('comments');
            $table->foreignId('news_id')->references('id')->on('news')->onDelete('cascade');
            $table->timestamps();
        });
        // Schema::create('comments', function (Blueprint $table) {
        //     $table->uuid()->primary();
        //     $table->string('name');
        //     $table->text('comments');
        //     $table->foreignUuid('news_id')->references('uuid')->on('news')->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
