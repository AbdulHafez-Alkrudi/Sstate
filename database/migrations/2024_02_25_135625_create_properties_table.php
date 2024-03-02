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
        Schema::disableForeignKeyConstraints();
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('street_id')->constrained();
            $table->float('price');
            $table->integer('floor');
            $table->smallInteger('number_of_rooms');
            $table->smallInteger('number_of_kitchens');
            $table->smallInteger('number_of_bathrooms');
            $table->float('space');
            $table->boolean('rent');
            $table->integer('popularity')->default(0);
            $table->timestamps();

        });
        Schema::enableForeignKeyConstraints();
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
