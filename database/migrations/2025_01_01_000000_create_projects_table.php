<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 8)->unique();
            $table->string('name');
            $table->text('editorial_line')->nullable();
            $table->text('target_audience')->nullable();
            $table->boolean('is_default')->default(false);
            $table->foreignId('wordpress_credential_id')->nullable()->constrained('wordpress_credentials')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
