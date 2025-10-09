<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    protected $connection;

    public function __construct()
    {
        $this->connection = env('HELP_CENTER_DB_CONNECTION', 'help_center_db');
    }
    public function up(): void
    {
        Schema::connection($this->connection)->create('topic_articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->unsignedBigInteger('topic_section_id');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('status')->default('active');
            $table->boolean('is_marked')->default(false);

            $table->timestamps();
            $table->unique(['topic_section_id', 'title']);
            $table->unique(['topic_section_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('topic_articles');
    }
};
