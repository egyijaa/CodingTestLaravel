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
        Schema::create('custom_pages', function (Blueprint $table) {
            $table->id();
            $table->text('custom_url');
            $table->text('page_content');
            $table->foreignId('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Schema::create('custom_pages', function (Blueprint $table) {
        //     $table->uuid()->primary();
        //     $table->text('custom_url');
        //     $table->text('page_content');
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
        Schema::dropIfExists('custom_pages');
    }
};
