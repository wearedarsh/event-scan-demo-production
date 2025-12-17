<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_html_layouts', function (Blueprint $table) {
            $table->id();
            $table->string('label'); // Friendly name
            $table->string('key_name')->unique(); // machine key: 'admin', 'customer'
            $table->text('html_content'); // Full Blade HTML layout
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_html_layouts');
    }
};
