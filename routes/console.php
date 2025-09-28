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
    $orders = Order::where('created_at', '<', now()->subDays(3))->get();
    foreach ($orders as $order) {
        if($order->downloaded_file){
            $path = public_path('upload/' . $order->downloaded_file);
            if (file_exists($path)) {
                unlink($path);
            }
        }
        $order->delete();
    }
    Log::info("Auto-deleted orders older than 4 days at " . now());
})->dailyAt('00:30');
