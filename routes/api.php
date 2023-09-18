<?php

use ZarulIzham\AutoDebit\Http\Controllers\BICCodeController;

Route::prefix('api')->as('api.')->middleware('api')->group(function () {
    Route::get('auto-debit/banks', [BICCodeController::class, 'banks'])->name('auto-debit.banks');
});
