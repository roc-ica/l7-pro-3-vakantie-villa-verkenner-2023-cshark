<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('geo_option_house_object', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('geo_option_id');
            $table->unsignedBigInteger('house_object_id');
            $table->foreign('geo_option_id')->references('id')->on('geo_option')->onDelete('cascade');
            $table->foreign('house_object_id')->references('id')->on('house_object')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('geo_option_house_object');
    }
};