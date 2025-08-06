<?php

use Illuminate\Support\Facades\Schedule;

$cronPath = storage_path('logs/cronjob.log');
Schedule::command('general:cron')->dailyAt('08:00')->timezone('Asia/Jakarta')->withoutOverlapping(1);
