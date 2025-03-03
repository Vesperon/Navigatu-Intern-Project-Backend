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
        Schema::create('returned', function (Blueprint $table) {
            $table->id('returned_id');
            $table->integer('borrow_id');
            $table->foreign('borrow_id')->references('borrow_id')->on('borrow')->onUpdate('cascade')->onDelete('cascade');
            $table->string('item');
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
        Schema::dropIfExists('returned');
    }
};
