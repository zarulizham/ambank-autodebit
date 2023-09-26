<?php

namespace ZarulIzham\AutoDebit\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DebitTransaction extends Model
{
    public function getTable()
    {
        return config('autodebit.table_name.debit_transactions', parent::getTable());
    }

    protected $fillable = [
        'consent_id',
        'amount',
        'bill_ref_no',
        'bill_description',
        'debit_status',
        'reason_code',
        'reason_detail',
        'reason_code',
        'debit_account_id',
        'debited_at',
        'request_body',
        'response_body',
    ];

    /**
     * Get the consent that owns the DebitTransaction
     */
    public function consent(): BelongsTo
    {
        return $this->belongsTo(Consent::class, 'consent_id', 'consent_id');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'request_body' => 'object',
        'response_body' => 'object',
        'amount' => 'double',
        'debited_at' => 'datetime',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected function debitStatus(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return match ($value) {
                    'PNDG' => __('Pending'),
                    'ACSP' => __('Successful'),
                    'RJCT' => __('Rejected'),
                    default => $value,
                };
            },
        );
    }
}
