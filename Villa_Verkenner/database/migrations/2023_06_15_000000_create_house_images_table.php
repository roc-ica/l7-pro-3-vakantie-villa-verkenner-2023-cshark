<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('house_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('house_object_id');
            $table->string('image_path');
            $table->boolean('is_primary')->default(false);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
        
        if (Schema::hasTable('house_object') && Schema::hasColumn('house_object', 'id')) {
            Schema::table('house_images', function (Blueprint $table) {
                $table->foreign('house_object_id')
                      ->references('id')
                      ->on('house_object')
                      ->onDelete('cascade');
            });
        }

        if (Schema::hasColumn('house_object', 'image')) {
            $houses = DB::table('house_object')->whereNotNull('image')->get();
            foreach ($houses as $house) {
                DB::table('house_images')->insert([
                    'house_object_id' => $house->id,
                    'image_path' => $house->image,
                    'is_primary' => true,
                    'display_order' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_images');
    }
};
