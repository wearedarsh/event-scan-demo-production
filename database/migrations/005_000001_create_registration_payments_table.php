<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registration_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_payment_method_id')->nullable()->constrained('event_payment_methods')->nullOnDelete();
            $table->integer('amount_cents')->nullable();
            $table->integer('total_cents')->nullable();
            $table->string('provider_reference')->nullable()->index();
            $table->string('provider')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('registration_payments');
    }
};
