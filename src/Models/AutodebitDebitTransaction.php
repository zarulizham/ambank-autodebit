<?php

namespace ZarulIzham\AutoDebit\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class AutoDebitDebitTransaction extends Model
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
        'request_body',
        'response_body',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'request_body' => 'object',
        'response_body' => 'object',
        'amount' => 'double',
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
