<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GenerateRandomCodes extends Command
{
    protected $signature = 'generate:random-codes';

    protected $description = 'Generate 1732 random codes and store them into a file with timestamp.';

    public function handle()
    {
        $total = 1732;
        $codes = [];

        $this->info("🔄 Mulai generate $total kode random...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        for ($i = 0; $i < $total; $i++) {
            $code = strtoupper(Str::random(10));
            $codes[] = $code;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Buat nama file dengan timestamp
        $timestamp = now()->format('Ymd_His');
        $filename = "random_codes_$timestamp.txt";
        $path = storage_path("app/$filename");

        file_put_contents($path, implode(PHP_EOL, $codes));

        $this->info("✅ Selesai! Total $total kode disimpan ke: $filename");
        return 0;
    }
}
