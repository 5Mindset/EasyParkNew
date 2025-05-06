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
        Schema::create('guest_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique(); 
            $table->string('owner_name'); 
            $table->foreignId('vehicle_model_id')->constrained()->onDelete('cascade'); 
            $table->timestamp('entry_time'); 
            $table->timestamp('exit_time')->nullable(); 
            $table->enum('status', ['parked', 'exited'])->default('parked'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_vehicles');
    }
};
