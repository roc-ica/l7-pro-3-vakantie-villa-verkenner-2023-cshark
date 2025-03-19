<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feature', function (Blueprint $table) {
            $table->id(); // Add this primary key
            $table->string('name'); // Optionally add a column
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feature');
    }
};