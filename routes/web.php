<?php

use ZarulIzham\AutoDebit\Http\Controllers\CallbackController;

$routePath = config('duitnow.callback.path');
$routeName = config('duitnow.callback.name');

Route::match(['get', 'post'], $routePath, CallbackController::class)->name($routeName);
