<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('feedback_form_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feedback_form_id')->constrained();
            $table->foreignId('feedback_form_submission_id')->constrained();
            $table->foreignId('feedback_form_question_id')->constrained();
            $table->text('answer')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback_form_responses');
    }
};
