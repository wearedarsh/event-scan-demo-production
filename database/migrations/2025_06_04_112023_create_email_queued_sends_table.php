<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_queued_sends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_broadcast_id')
                  ->constrained('email_broadcasts')
                  ->onDelete('cascade');
            $table->foreignId('recipient_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            $table->string('email_address');
            $table->string('subject');
            $table->mediumText('html_content');
            $table->string('status')->default('pending');
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->text('last_error')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_queued_sends');
    }
};