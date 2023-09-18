<?php

namespace ZarulIzham\AutoDebit\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class AutoDebitTermination extends Model
{
    public function getTable()
    {
        return config('autodebit.table_name.terminations', parent::getTable());
    }

    protected $fillable = [
        'consent_id',
        'cancellation_reason',
        'consent_status',
        'request_status',
        'reason_code',
    ];

    protected function consentStatus(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return match ($value) {
                    'ACTV' => __('Active'),
                    'ICTV' => __('Inactive'),
                    'SUSP' => __('Suspended'),
                    'SUSB' => __('Suspended (Bank)'),
                    'ACTB' => __('Activated'),
                    'PNDG' => __('Pending'),
                    'PDAU' => __('Pending Auth.'),
                    'CANC' => __('Cancelled'),
                    default => $value,
                };
            },
        );
    }

    protected function requestStatus(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return match ($value) {
                    'ACTC' => __('Accepted'),
                    'RJCT' => __('Rejected'),
                    default => $value,
                };
            },
        );
    }
}
