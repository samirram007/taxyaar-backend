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
        Schema::create('related_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('topic_article_id');
            $table->unsignedBigInteger('related_topic_article_id');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('related_articles');
    }
};
