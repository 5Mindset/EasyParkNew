<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GenerateRandomCodes extends Command
{
    protected $signature = 'generate:random-codes {--prefix= : Optional prefix for each code}';

    protected $description = 'Generate 1732 random codes, log them, and simulate errors for full flow.';

    public function handle()
    {
        $total = 1732;
        $prefix = strtoupper($this->option('prefix') ?? '');
        $uniqueCodes = collect();
        $errors = 0;
        $startTime = microtime(true);

        $this->info("🔧 Mulai generate $total kode random...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        for ($i = 0; $i < $total; $i++) {
            try {
                if ($i % 500 === 0 && $i !== 0) {
                    throw new \Exception("Simulasi error pada iterasi ke-$i");
                }

                do {
                    $code = $prefix . strtoupper(Str::random(10));
                } while ($uniqueCodes->contains($code));

                $uniqueCodes->push($code);

                // Simpan ke database (simulasi log)
                DB::table('code_logs')->insert([
                    'code' => $code,
                    'error' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            } catch (\Exception $e) {
                $errors++;
                Log::error("❌ Error generate code [$i]: " . $e->getMessage());

                DB::table('code_logs')->insert([
                    'code' => 'ERROR_' . $i,
                    'error' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Simpan ke file
        $timestamp = now()->format('Ymd_His');
        $filename = "random_codes_$timestamp.txt";
        file_put_contents(storage_path("app/$filename"), $uniqueCodes->join(PHP_EOL));

        $duration = round(microtime(true) - $startTime, 2);

        $this->info("✅ Selesai generate $uniqueCodes->count() kode unik dalam $duration detik.");
        $this->info("📁 Disimpan ke file: $filename");
        $this->info("📄 Total error yang disimulasikan: $errors");
        Log::info("✅ GenerateRandomCodes selesai. Total: $total | Error: $errors | Durasi: {$duration}s");

        return 0;
    }
}
