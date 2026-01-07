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
        Schema::create('feedback_form_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feedback_form_id')->constrained();
            $table->text('options_text')->nullable();
            $table->text('question');
            $table->text('type'); // eg radio, text, textarea
            $table->foreignId('feedback_form_group_id')->constrained();
            $table->integer('display_order')->default(0);
            $table->boolean('is_required')->default(false);
            $table->unsignedBigInteger('visible_if_question_id')->nullable();
            $table->string('visible_if_answer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback_form_questions', function (Blueprint $table) {
            //
        });
    }
};
