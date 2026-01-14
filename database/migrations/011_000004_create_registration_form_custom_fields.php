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
        Schema::create('registration_form_custom_field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->foreignId('registration_form_input_id');
            $table->foreign('registration_form_input_id', 'reg_input_fk')->references('id')->on('registration_form_inputs');
            $table->text('value')->nullable();
            $table->timestamps();
            $table->unique(['registration_id', 'registration_form_input_id'], 'registration_form_custom_field_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_form_custom_field_values');
    }
};
