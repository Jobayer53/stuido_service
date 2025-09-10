<?php

use App\Models\Order;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $deleted = \App\Models\Order::where('created_at', '<', now()->subDays(4))->delete();
    Log::info("Auto-deleted {$deleted} orders older than 4 days at " . now());
})->dailyAt('00:30');
