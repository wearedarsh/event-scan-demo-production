<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_signatures', function (Blueprint $table) {
            $table->id();
            $table->string('key_name')->unique();
            $table->string('title');
            $table->mediumText('html_content');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_signatures');
    }
};
