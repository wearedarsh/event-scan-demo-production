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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();

            $table->string('booking_reference')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('event_id')->constrained();
            $table->foreignId('attendee_group_id')->nullable()->constrained();
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('address_line_one')->nullable();
            $table->string('town')->nullable();
            $table->string('postcode')->nullable();
            $table->foreignId('country_id')->nullable()->constrained();
            $table->string('currently_held_position')->nullable();
            $table->foreignId('attendee_type_id')->nullable()->constrained();
            $table->string('attendee_type_other')->nullable();
            $table->string('mobile_country_code')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();
            $table->mediumText('special_requirements')->nullable();
            $table->boolean('is_complete')->default(false);
            $table->foreignId('event_payment_method_id')->nullable()->constrained('event_payment_methods')->nullOnDelete();
            $table->integer('total_cents')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_intent_id')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->string('email_subscriber_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
