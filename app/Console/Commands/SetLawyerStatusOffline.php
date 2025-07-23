<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetLawyerStatusOffline extends Command
{
    protected $signature = 'lawyer:status-off';
    protected $description = 'Set status pengacara menjadi Off (0) setiap jam 10 malam';

    public function handle()
    {
        DB::table('pengacaras') 
            ->where('status_konsultasi', 1)
            ->update(['status_konsultasi' => 0]);

        $this->info('Status pengacara diubah ke OFF.');

        \Log::info('lawyer:status-off dijalankan');

    }
}
