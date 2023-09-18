<?php

namespace ZarulIzham\AutoDebit\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AutodebitRegistration extends Model
{
    protected $table = config('autodebit.table_name.registrations');

    protected $fillable = [
        'registrationable_id',
        'registrationable_type',
        'consent_id',
        'consent_status',
        'max_amount',
        'consent_frequency',
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
        'max_amount' => 'double',
    ];

    public function registrationable(): MorphTo
    {
        return $this->morphTo();
    }

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
}
