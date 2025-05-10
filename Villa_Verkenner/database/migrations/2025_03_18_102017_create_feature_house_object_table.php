<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feature_house_object', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('house_object_id');
            $table->unsignedBigInteger('feature_id');
            $table->foreign('house_object_id')->references('id')->on('house_object')->onDelete('cascade');
            $table->foreign('feature_id')->references('id')->on('feature')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feature_house_object');
    }
};