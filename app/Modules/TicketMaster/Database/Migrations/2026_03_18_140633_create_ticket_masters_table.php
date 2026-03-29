<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\DevicePlatform;
use App\Enums\TicketStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_masters', function (Blueprint $table) {
            $table->id();
            $table->string("ticket_id")->unique(); // this can be called as reference number
            $table->enum('assigned_by', ['employee', 'system', 'agent_1', 'agent_2'])->default('system');
            $table->unsignedBigInteger('assigned_by_id')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->unsignedBigInteger("type_id")->nullable();
            $table->unsignedBigInteger("priority_id")->nullable();
            $table->unsignedBigInteger("status_id")->nullable();
            // these are for when ticket status will be on hold
            $table->date("paused_at")->nullable();
            $table->string("paused_duration")->nullable();

            $table->string('mobile_number');
            $table->string('email');
            $table->string('pan');
            $table->enum('platform', DevicePlatform::cases())->default('web');
            $table->string('subject')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_masters');
    }
};