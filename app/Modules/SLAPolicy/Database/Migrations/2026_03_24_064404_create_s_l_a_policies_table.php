<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('s_l_a_policies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('ticket_status_id')->nullable();
            $table->unsignedBigInteger('trigger_after_minutes');
            $table->enum('action_type', ['notify', 'alert', 'resassign']);
            $table->string('escalation_level'); // for chaining alert and to update the action also
            $table->unsignedBigInteger('next_trigger_minutes');
            $table->boolean('respect_business_hours')->default(true);
            $table->boolean('respect_holidays');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('s_l_a_policies');
    }
};