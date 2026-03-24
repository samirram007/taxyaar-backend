<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('s_l_a_policy_actions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('action_type');
            $table->string('target_type');
            $table->string('target_id');
            $table->text('message_template');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('s_l_a_policy_actions');
    }
};