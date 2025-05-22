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
        // Buat tabel parking_records
        Schema::create('parking_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('parking_area_id')->constrained()->onDelete('cascade');
            $table->timestamp('entry_time');
            $table->timestamp('exit_time')->nullable();
            $table->enum('status', ['parked', 'exited'])->default('parked');
            $table->timestamps();
        });

        // Buat tabel parking_logs untuk mencatat log keluar
        Schema::create('parking_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parking_record_id')->constrained('parking_records')->onDelete('cascade');
            $table->timestamp('logged_exit_time');
            $table->timestamps();
        });

        // Buat trigger untuk mencatat log saat exit_time diisi
        DB::unprepared('
            CREATE TRIGGER trg_after_exit_time_update
            AFTER UPDATE ON parking_records
            FOR EACH ROW
            BEGIN
                IF NEW.exit_time IS NOT NULL AND OLD.exit_time IS NULL THEN
                    INSERT INTO parking_logs (parking_record_id, logged_exit_time, created_at, updated_at)
                    VALUES (NEW.id, NEW.exit_time, NOW(), NOW());
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus trigger
        DB::unprepared('DROP TRIGGER IF EXISTS trg_after_exit_time_update');

        // Hapus tabel
        Schema::dropIfExists('parking_logs');
        Schema::dropIfExists('parking_records');
    }
};
