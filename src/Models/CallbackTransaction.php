<?php

namespace ZarulIzham\AutoDebit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CallbackTransaction extends Model
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

    /**
     * Get the consent that owns the Termination
     */
    public function consent(): BelongsTo
    {
        return $this->belongsTo(Consent::class, 'consent_id', 'consent_id');
    }
}
