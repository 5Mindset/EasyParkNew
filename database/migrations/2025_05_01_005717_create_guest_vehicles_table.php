<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Buat tabel guest_vehicles
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

        // Buat tabel log keluar guest
        Schema::create('guest_vehicle_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_vehicle_id')->constrained('guest_vehicles')->onDelete('cascade');
            $table->timestamp('logged_exit_time');
            $table->timestamps();
        });

        // Trigger: mencatat log saat exit_time pertama kali diisi
        DB::unprepared('
            CREATE TRIGGER trg_after_guest_exit_time_update
            AFTER UPDATE ON guest_vehicles
            FOR EACH ROW
            BEGIN
                IF NEW.exit_time IS NOT NULL AND OLD.exit_time IS NULL THEN
                    INSERT INTO guest_vehicle_logs (guest_vehicle_id, logged_exit_time, created_at, updated_at)
                    VALUES (NEW.id, NEW.exit_time, NOW(), NOW());
                END IF;
            END
        ');
    }

    public function down(): void
    {
        // Hapus trigger
        DB::unprepared('DROP TRIGGER IF EXISTS trg_after_guest_exit_time_update');

        // Hapus tabel log dan guest_vehicles
        Schema::dropIfExists('guest_vehicle_logs');
        Schema::dropIfExists('guest_vehicles');
    }
};
