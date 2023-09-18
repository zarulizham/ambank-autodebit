<?php

namespace ZarulIzham\AutoDebit\Commands;

use Illuminate\Console\Command;
use ZarulIzham\AutoDebit\Facades\AutoDebit;

class AutoDebitAuthenticateCommand extends Command
{
    public $signature = 'autodebit:authenticate';

    public $description = 'Test authentication';

    public function handle(): int
    {
        $token = AutoDebit::authenticate();

        $this->info('Token: '.$token);

        return self::SUCCESS;
    }
}
