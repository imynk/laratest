<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Console\Command;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// app()->booted(function () {
//     $schedule = app(Schedule::class);
//     $schedule->command('fetch:users')->everyMinute();
// });