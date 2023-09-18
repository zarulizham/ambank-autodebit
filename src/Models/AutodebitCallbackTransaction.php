<?php

namespace ZarulIzham\AutoDebit\Models;

use Illuminate\Database\Eloquent\Model;

class AutodebitCallbackTransaction extends Model
{
    protected $table = config('autodebit.table_name.callback_transactions');

    protected $fillable = [
        'consent_id',
        'callback_data',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'callback_data' => 'object',
    ];
}
