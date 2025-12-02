<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('label_formats', function (Blueprint $table) {
            $table->id();

            // Basic info
            $table->string('name');
            $table->string('key_name')->unique();

            // Layout configuration
            $table->unsignedInteger('rows');
            $table->unsignedInteger('columns');
            $table->unsignedInteger('labels_per_sheet');

            // Dimensions in millimetres
            $table->decimal('label_width_mm', 8, 2);
            $table->decimal('label_height_mm', 8, 2);

            // Gaps (optional)
            $table->decimal('row_gap_mm', 8, 2)->default(0);
            $table->decimal('column_gap_mm', 8, 2)->default(0);
            $table->decimal('central_gap_mm', 8, 2)->default(0);

            // Orientation: portrait / landscape
            $table->enum('orientation', ['portrait', 'landscape'])
                  ->default('portrait');

            // System toggle
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('label_formats');
    }
};
