<?php

namespace ZarulIzham\AutoDebit\Commands;

use Illuminate\Console\Command;

class AutoDebitCommand extends Command
{
    public $signature = 'laravel-ambank-autodebit';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
