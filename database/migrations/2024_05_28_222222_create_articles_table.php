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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('article_id')->nullable();
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->dateTime('date')->nullable();
            $table->foreignId('author_id')->nullable()->considered('authors')->cascadeOnDelete();
            $table->foreignId('source_id')->nullable()->constrained('sources')->cascadeOnDelete();
            $table->foreignId('sub_category_id')->constrained('sub_categories')->cascadeOnDelete();
            $table->index('sub_category_id');
            $table->index('author_id');
            $table->index('source_id');
            $table->index('date');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
