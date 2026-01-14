<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registration_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->foreignId('ticket_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('registration_form_input_id')->nullable()->constrained()->nullOnDelete();
            $table->string('original_name');
            $table->string('file_path');
            $table->timestamps();
            $table->unique(['registration_id', 'ticket_id'], 'registration_ticket_document_unique');
            $table->unique(['registration_id', 'registration_form_input_id'], 'registration_input_document_unique');
        });


    }
    
    public function down(): void
    {
        Schema::dropIfExists('registration_documents');
    }
};
