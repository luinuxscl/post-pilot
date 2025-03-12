<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('wordpress_credentials', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique();
            $table->string('site_url')->index();
            $table->string('username');
            $table->string('password');
            $table->boolean('is_connected')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wordpress_credentials');
    }
};
