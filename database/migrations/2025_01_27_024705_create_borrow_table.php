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
        Schema::create('borrow', function (Blueprint $table) {
            $table->id('borrow_id');
            $table->integer('item_id');
            $table->foreign('item_id')->references('item_id')->on('property')->onUpdate('cascade')->onDelete('cascade');
            $table->string('item');
            $table->string('category');
            $table->date('expected_return');
            $table->integer('quantity');
            $table->string('office');
            $table->string('person');
            $table->string('purpose');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow');
    }
};
