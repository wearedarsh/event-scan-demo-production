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
        Schema::create('registration_form_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_form_id')->constrained()->onDelete('cascade');
            $table->string('label');
            $table->string('key_name');
            $table->string('type')->default('rigid');
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_form_steps');
    }
};
