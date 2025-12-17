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
        Schema::create('event_session_groups', function (Blueprint $table) {
            $table->id();
            $table->string('friendly_name');
            $table->integer('display_order')->default(0);
            $table->boolean('active')->default(0);
            $table->foreignId('event_id')->constrained()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_session_groups');
    }
};
