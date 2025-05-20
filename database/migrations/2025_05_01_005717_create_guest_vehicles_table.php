<?php
// database/migrations/xxxx_xx_xx_create_guest_vehicles_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('guest_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number', 20)->unique();
            $table->string('name', 100);
            $table->foreignId('vehicle_type_id')->constrained()->onDelete('cascade');
            $table->timestamp('entry_time')->nullable();
            $table->timestamp('exit_time')->nullable();
            $table->enum('status', ['parked', 'exited']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guest_vehicles');
    }
};
