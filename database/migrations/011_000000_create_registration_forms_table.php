<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('registration_forms', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('key_name');
            $table->string('type');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('registration_forms');
    }
};
