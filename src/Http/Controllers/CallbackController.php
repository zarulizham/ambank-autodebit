<?php

namespace ZarulIzham\AutoDebit\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use ZarulIzham\AutoDebit\Models\CallbackTransaction;

class CallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        CallbackTransaction::create([
            'callback_data' => $request->all(),
        ]);
    }
}
