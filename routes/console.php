<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

// Langkah 1: Panggil instance dari class Scheduler
// Ini sama dengan parameter '$schedule' yang biasanya ada di Kernel.php
$schedule = App::make(Schedule::class);

// Langkah 2: Daftarkan jadwal Anda di sini, sama persis seperti di Kernel.php
$schedule->command('lawyer:status-off')->dailyAt('22:00');
$schedule->command('consultations:update-expired')->everyMinute();
$schedule->command('consultations:unresponsive')->everyMinute();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
