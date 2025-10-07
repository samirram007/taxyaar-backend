<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection;

    public function __construct()
    {
        $this->connection = env('HELP_CENTER_DB_CONNECTION', 'help_center_db');
    }
    public function up(): void
    {
        Schema::connection($this->connection)->create('topic_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_category_id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('topic_sections');

    }
};
