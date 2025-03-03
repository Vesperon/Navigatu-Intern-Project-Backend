<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('property', function (Blueprint $table) {
            $table->id('item_id');
            $table->string('property_num')->nullable()->unique();
            $table->string('serial_num')->nullable()->unique();
            $table->string('item');
            $table->string('description');
            $table->string('category');
            $table->integer('quantity');
            $table->string('unit');
            $table->json('set_items')->nullable();
            $table->string('tbi_assigned');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item');
    }


};
