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
        Schema::create('registration_form_inputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_form_step_id')->constrained()->onDelete('cascade');
            $table->string('key_name');
            $table->string('label');
            $table->string('placeholder')->nullable();
            $table->string('help')->nullable();
            $table->string('type');
            $table->boolean('required')->default(false);
            $table->integer('col_span')->default(6);
            $table->json('options')->nullable();
            $table->json('validation_rules')->nullable();
            $table->json('validation_messages')->nullable();
            $table->integer('display_order')->default(0);
            $table->string('relation_model')->nullable();
            $table->string('allowed_file_types')->nullable();
            $table->boolean('row_start')->default(false);
            $table->boolean('row_end')->default(false);
            $table->boolean('custom')->default(false);
            $table->timestamps();
            $table->unique(['registration_form_step_id', 'key_name'], 'registration_form_steps_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_form_inputs');
    }
};
