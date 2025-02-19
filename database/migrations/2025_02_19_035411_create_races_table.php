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
        Schema::create('races', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id');
            $table->unsignedBigInteger('league_id');
            $table->integer('race_number');
            $table->decimal('test_1');
            $table->decimal('test_2');
            $table->decimal('total_score')->nullable();
            $table->string('position')->nullable();
            $table->timestamps();

            $table->foreign('car_id')->references('id')->on('cars')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('league_id')->references('id')->on('leagues')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('races');
    }
};
