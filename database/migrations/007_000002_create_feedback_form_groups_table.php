<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback_form_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feedback_form_id')->constrained();
            $table->foreignId('feedback_form_step_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback_form_groups');
    }
};
