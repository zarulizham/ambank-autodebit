<?php

namespace ZarulIzham\AutoDebit\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use ZarulIzham\AutoDebit\Models\BICCode;

class BICCodeController extends Controller
{
    public function banks(Request $request)
    {
        $bicCodes = BICCode::get();

        return response()->json([
            'banks' => $bicCodes,
        ], 200);
    }
}
