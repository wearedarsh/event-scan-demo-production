<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('branding_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('branding_platform_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('key_name');
            $table->string('path');

            $table->string('alt_text')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();

            $table->string('custom_classes')->nullable();

            $table->timestamps();

            $table->unique(['branding_platform_id', 'key_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branding_images');
    }
};
