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
        Schema::create('feedback_form_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feedback_form_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable(); // optional step title
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_form_steps_table');
    }
};
