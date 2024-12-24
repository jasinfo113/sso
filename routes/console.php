<?php

use Illuminate\Support\Facades\Schedule;

$cronPath = storage_path('logs/cronjob.log');
Schedule::command('general:cron')->everyMinute()->timezone('Asia/Jakarta')->withoutOverlapping(1)->appendOutputTo($cronPath);
Schedule::command('birthday:cron')->dailyAt('08:00')->timezone('Asia/Jakarta')->withoutOverlapping(1);
