<?php

use App\Telegram\Handler;
use Illuminate\Support\Facades\Route;
use DefStudio\Telegraph\Telegraph;

Route::get('/', function () {
    return view('welcome');
});

Route::post('telegram/webhook', [Handler::class, 'handle']);
