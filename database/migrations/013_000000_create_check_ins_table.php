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
        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendee_id')->constrained('registrations');
            $table->foreignId('event_session_id')->constrained();
            $table->foreignId('event_id')->constrained();
            $table->timestamp('checked_in_at')->useCurrent();
            $table->foreignId('checked_in_by')->constrained('users');
            $table->string('checked_in_route');
            $table->timestamps();
            $table->unique(['attendee_id', 'event_id', 'event_session_id'], 'checkins_unique_triplet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_ins');
    }
};
