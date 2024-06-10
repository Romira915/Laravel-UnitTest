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
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->index(['user_id', 'id']);
        });

        Schema::create('article_published', function (Blueprint $table) {
            $table->uuid('article_id')->primary();
            $table->uuid('user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('article_id')->references('id')->on('articles');

            $table->index(['user_id', 'article_id']);
        });

        Schema::create('article_details', function (Blueprint $table) {
            $table->uuid('article_id')->primary();
            $table->uuid('user_id');
            $table->string('title', 191);
            $table->text('body');
            $table->text('thumbnail_path')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('article_id')->references('id')->on('articles');

            $table->index(['user_id', 'article_id']);
        });

        Schema::create('article_images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('article_id');
            $table->uuid('user_id');
            $table->text('image_path');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('article_id')->references('id')->on('articles');

            $table->index(['user_id', 'article_id']);
        });

        Schema::create('article_tags', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('article_id');
            $table->uuid('user_id');
            $table->string('tag_name', 191);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('article_id')->references('id')->on('articles');

            $table->index(['user_id', 'article_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_published');
        Schema::dropIfExists('article_details');
        Schema::dropIfExists('article_images');
        Schema::dropIfExists('article_tags');
    }
};
