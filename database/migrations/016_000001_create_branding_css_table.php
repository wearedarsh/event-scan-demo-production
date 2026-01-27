<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('branding_css', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branding_platform_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('key_name');
            $table->string('name');
            $table->longText('css');

            $table->unsignedInteger('version')->default(1);
            $table->boolean('is_active')->default(false);

            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();

            $table->index(['branding_platform_id', 'is_active']);
            $table->unique(['branding_platform_id', 'version']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branding_css');
    }
};
