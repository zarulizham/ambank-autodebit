<?php

namespace ZarulIzham\AutoDebit\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Consent extends Model
{
    public function getTable()
    {
        return config('autodebit.table_name.consents', parent::getTable());
    }

    protected $fillable = [
        'userable_id',
        'userable_type',
        'debitable_id',
        'debitable_type',
        'consent_id',
        'consent_status',
        'max_amount',
        'consent_frequency',
        'debtor_agent_bic',
        'debtor_account_id',
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

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'request_body',
        'response_body',
        'debitable_id',
        'debitable_type',
        'userable_id',
        'userable_type',
        'debtor_account_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'debtor_account_id_masked',
    ];

    public function debitable(): MorphTo
    {
        return $this->morphTo();
    }

    public function userable(): MorphTo
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
                    'FAIL' => __('Failed'),
                    default => $value,
                };
            },
        );
    }

    public function debitTransactions(): HasMany
    {
        return $this->hasMany(DebitTransaction::class, 'consent_id', 'consent_id');
    }

    /**
     * Get the termination associated with the Consent
     */
    public function termination(): HasOne
    {
        return $this->hasOne(Termination::class, 'consent_id', 'consent_id')->latestOfMany();
    }

    public function callbacks(): HasMany
    {
        return $this->hasMany(CallbackTransaction::class, 'consent_id', 'consent_id');
    }

    protected function getExpiryDateAttribute()
    {
        try {
            return Carbon::createFromFormat('Y-m-d', $this->request_body->expiryDate)->startOfDay();
        } catch (\Throwable $th) {
            return null;
        }
    }

    /**
     * Get the bank that owns the Consent
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(BICCode::class, 'debtor_agent_bic', 'bic_code');
    }

    public function getDebtorAccountIdMaskedAttribute()
    {
        return Str::mask($this->debtor_account_id ?? '', '*', 0, -4) ?: '-';
    }
}
