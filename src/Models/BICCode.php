<?php

namespace ZarulIzham\AutoDebit\Models;

use Illuminate\Database\Eloquent\Model;

class BICCode extends Model
{
    protected $table = config('autodebit.table_name');
    protected $fillable = [
        'bank_name',
        'bank_name',
        'bic_code',
    ];
}