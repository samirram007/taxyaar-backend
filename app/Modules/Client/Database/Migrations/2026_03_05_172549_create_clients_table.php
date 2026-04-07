<?php

use App\Enums\PrimaryMobileBelongEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



return new class extends Migration {
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('pan')->unique();
            $table->string('email')->unique();
            $table->string('last_name');
            $table->string('father_name');
            $table->string('residential_status_code')->nullable();
            $table->string('isd_code')->nullable();
            // $table->enum('priMobBelongsTo',PrimaryMobileBelongEnum::getValues());
            // $table->enum('priEmailRelationId',PrimaryMobileBelongEnum::getValues());
            $table->boolean("is_verified")->default(false);
            $table->date("valid_upto")->nullable();
            $table->string('pin_code')->nullable();
            $table->string('zip_code')->nullable();
            $table->string("country_code")->nullable();
            $table->string("state_code")->nullable();
            $table->date('dob');
            $table->string('mobile_number');
            $table->string('gender');
            $table->string('country')->default('IN');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
