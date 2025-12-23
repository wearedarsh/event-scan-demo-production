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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('location');
            $table->date('date_start');
            $table->date('date_end');
            $table->integer('event_attendee_limit');
            $table->decimal('vat_percentage', 6, 2);
            $table->boolean('full')->default(false);
            $table->boolean('active')->default(true);
            $table->boolean('template')->default(false);
            $table->boolean('show_email_marketing_opt_in')->default(false);
            $table->boolean('auto_email_opt_in')->default(false);
            $table->string('email_list_id')->nullable();
            $table->string('email_opt_in_description')->nullable();
            $table->boolean('provisional')->default(false);
            $table->boolean('registration_type')->default('paid');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
