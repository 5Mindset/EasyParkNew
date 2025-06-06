<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateRandomCodes extends Command
{
    protected $signature = 'generate:random-codes';

    protected $description = 'Generate 1732 random codes as a simulation or placeholder.';

    public function handle()
    {
        $total = 1732;
        $codes = [];

        for ($i = 0; $i < $total; $i++) {
            $codes[] = strtoupper(Str::random(10));
        }

        // Simulasi output ke terminal
        foreach ($codes as $index => $code) {
            $this->line("[$index] $code");
        }

        // Bisa disimpan ke file juga kalau mau
        // file_put_contents(storage_path('app/random_codes.txt'), implode(PHP_EOL, $codes));

        $this->info("✅ Total $total kode random berhasil digenerate.");
        return 0;
    }
}
