<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('client_settings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained('client_setting_categories')
                ->cascadeOnDelete();

            $table->string('key_name'); // support_email, invoice_prefix
            $table->string('label');
            $table->string('type')->default('text'); // text, textarea, email, select, boolean
            $table->unsignedInteger('display_order')->default(0);

            $table->text('value')->nullable();

            $table->timestamps();

            $table->unique(['category_id', 'key_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_settings');
    }
};
