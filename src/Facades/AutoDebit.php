<?php

namespace ZarulIzham\AutoDebit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ZarulIzham\AutoDebit\AutoDebit
 */
class AutoDebit extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \ZarulIzham\AutoDebit\AutoDebit::class;
    }
}
