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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('news_content');
            $table->foreignId('categories_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreignId('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Schema::create('news', function (Blueprint $table) {
        //     $table->uuid()->primary();
        //     $table->string('title');
        //     $table->text('news_content');
        //     $table->foreignUuid('categories_id')->references('uuid')->on('categories')->onDelete('cascade');
        //     $table->foreignId('created_by')->references('id')->on('users')->onDelete('cascade');
        //     $table->foreignId('updated_by')->references('id')->on('users')->onDelete('cascade');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
