<?php

namespace ZarulIzham\AutoDebit\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use ZarulIzham\AutoDebit\Models\AutodebitCallbackTransaction;

class CallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        AutodebitCallbackTransaction::create([
            'callback_data' => $request->all(),
        ]);
    }
}
