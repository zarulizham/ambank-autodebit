<?php

namespace ZarulIzham\AutoDebit\Traits;

use Illuminate\Support\Facades\Cache;

trait HasSrcRefNo
{
    public function getSrcRefNo()
    {
        $sequence = str_pad(Cache::increment('autodebit_sequence'), 6, '0', STR_PAD_LEFT);

        return config('autodebit.prefix_id').date('dmY').$sequence;
    }
}
