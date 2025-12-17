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
        Schema::create('attendee_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('colour')->nullable();
            $table->foreignId('event_id')->constrained();
            $table->string('label_colour')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendee_groups');
    }
};
