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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('price_cents')->nullable();
            $table->boolean('requires_document_upload')->default(false);
            $table->integer('max_volume')->default(1);
            $table->foreignId('ticket_group_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('requires_document_copy')->nullable();
            $table->boolean('active')->default(false);
            $table->integer('display_order')->default(1);
            $table->boolean('display_front_end')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
