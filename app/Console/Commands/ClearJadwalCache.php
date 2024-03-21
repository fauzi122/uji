<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearJadwalCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-jadwal-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pattern = storage_path('framework/cache/data/jadwal_ip_*');

        $files = glob($pattern);

        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        $this->info('Cache jadwal_ip_* sudah kosong.');
    }
}
