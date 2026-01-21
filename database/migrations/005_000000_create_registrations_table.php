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
            $table->string('email_subscriber_id')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('registration_status')->default('draft');
            $table->integer('last_intended_step')->nullable();
            $table->boolean('registration_form_locked')->default(false);
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
