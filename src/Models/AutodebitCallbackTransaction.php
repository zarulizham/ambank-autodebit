<?php

namespace ZarulIzham\AutoDebit\Models;

use Illuminate\Database\Eloquent\Model;

class AutoDebitCallbackTransaction extends Model
{
    public function getTable()
    {
        return config('autodebit.table_name.callback_transactions', parent::getTable());
    }

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
