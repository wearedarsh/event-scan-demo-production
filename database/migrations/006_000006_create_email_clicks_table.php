<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('email_send_id')
                  ->constrained('email_sends')
                  ->onDelete('cascade');
            $table->string('recipient_email');
            $table->text('url');                      
            $table->ipAddress('ip_address')->nullable(); 
            $table->text('user_agent')->nullable();    
            $table->timestamp('event_time'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_clicks');
    }
};