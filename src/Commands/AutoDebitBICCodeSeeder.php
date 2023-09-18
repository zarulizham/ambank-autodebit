<?php

namespace ZarulIzham\AutoDebit\Commands;

use Illuminate\Console\Command;
use ZarulIzham\AutoDebit\Models\BICCode;

class AutoDebitBICCodeSeeder extends Command
{
    public $signature = 'autodebit:bic_code:seed';

    public $description = 'Seed BIC Codes';

    public function handle(): int
    {
        $codes = [
            [
                'bank_name' => 'Affin Bank Berhad',
                'bank_code' => 'ABB',
                'bic_code' => 'PHBMMYKL',
            ],
            [
                'bank_name' => 'Alliance Bank Malaysia Berhad',
                'bank_code' => 'ABMB',
                'bic_code' => 'MFBBMYKL',
            ],
            [
                'bank_name' => 'Al-Rajhi',
                'bank_code' => 'ARM',
                'bic_code' => 'RJHIMYKL',
            ],
            [
                'bank_name' => 'Ambank Malaysia Berhad',
                'bank_code' => 'AMFB',
                'bic_code' => 'ARBKMYKL',
            ],
            [
                'bank_name' => 'Bank Islam Malaysia Berhad',
                'bank_code' => 'BIMB',
                'bic_code' => 'BIMBMYKL',
            ],
            [
                'bank_name' => 'Bank Kerjasama Rakyat Malaysia Berhad',
                'bank_code' => 'BKRB',
                'bic_code' => 'BKRMMYKL',
            ],
            [
                'bank_name' => 'Bank Muamalat Malaysia Bhd',
                'bank_code' => 'BMMB',
                'bic_code' => 'BMMBMYKL',
            ],
            [
                'bank_name' => 'Bank Pertanian Malaysia Berhad (Agrobank)',
                'bank_code' => 'BPM',
                'bic_code' => 'AGOBMYKL',
            ],
            [
                'bank_name' => 'Bank of America (M) Berhad',
                'bank_code' => 'BOA',
                'bic_code' => 'BOFAMY2X',
            ],
            [
                'bank_name' => 'Bank of China (M) Berhad',
                'bank_code' => 'BOCM',
                'bic_code' => 'BKCHMYKL',
            ],
            [
                'bank_name' => 'Bank Simpanan Nasional Berhad',
                'bank_code' => 'BSNB',
                'bic_code' => 'BSNAMYK1',
            ],
            [
                'bank_name' => 'BNP Paribas Malaysia Berhad',
                'bank_code' => 'BNP',
                'bic_code' => 'BNPAMYKL',
            ],
            [
                'bank_name' => 'CIMB Bank Berhad',
                'bank_code' => 'CIMB',
                'bic_code' => 'CIBBMYKL',
            ],
            [
                'bank_name' => 'China Construction Bank (M) Berhad',
                'bank_code' => 'PCBC',
                'bic_code' => 'PCBCMYKL',
            ],
            [
                'bank_name' => 'Citibank Berhad',
                'bank_code' => 'CITI',
                'bic_code' => 'CITIMYKL',
            ],
            [
                'bank_name' => 'Deutsche Bank (Malaysia) Berhad',
                'bank_code' => 'DB',
                'bic_code' => 'DEUTMYKL',
            ],
            [
                'bank_name' => 'Finexus Cards Sdn. Bhd.',
                'bank_code' => 'FIN',
                'bic_code' => 'FNXSMYNB',
            ],
            [
                'bank_name' => 'Hong Leong Bank Berhad',
                'bank_code' => 'HLB',
                'bic_code' => 'HLBBMYKL',
            ],
            [
                'bank_name' => 'HSBC Bank Malaysia Berhad',
                'bank_code' => 'HSBC',
                'bic_code' => 'HBMBMYKL',
            ],
            [
                'bank_name' => 'Industrial and Commercial Bank of China (M) Berhad',
                'bank_code' => 'ICB',
                'bic_code' => 'ICBKMYKL',
            ],
            [
                'bank_name' => 'JP Morgan Chase Bank Berhad',
                'bank_code' => 'JPMC',
                'bic_code' => 'CHASMYKX',
            ],
            [
                'bank_name' => 'Kuwait Finance House',
                'bank_code' => 'KFH',
                'bic_code' => 'KFHOMYKL',
            ],
            [
                'bank_name' => 'Maybank Berhad',
                'bank_code' => 'MBB',
                'bic_code' => 'MBBEMYKL',
            ],
            [
                'bank_name' => 'MBSB Bank Berhad',
                'bank_code' => 'MBSB',
                'bic_code' => 'AFBQMYKL',
            ],
            [
                'bank_name' => 'Mizuho Bank (Malaysia) Berhad',
                'bank_code' => 'MCBM',
                'bic_code' => 'MHCBMYKA',
            ],
            [
                'bank_name' => 'Bank of Tokyo-Mitsubishi UFJ (M) Berhad',
                'bank_code' => 'BOTM',
                'bic_code' => 'BOTKMYKX',
            ],
            [
                'bank_name' => 'OCBC Bank Berhad',
                'bank_code' => 'OCBC',
                'bic_code' => 'OCBCMYKL',
            ],
            [
                'bank_name' => 'Public Bank Berhad',
                'bank_code' => 'PBB',
                'bic_code' => 'PBBEMYKL',
            ],
            [
                'bank_name' => 'RHB Bank Berhad',
                'bank_code' => 'RHB',
                'bic_code' => 'RHBBMYKL',
            ],
            [
                'bank_name' => 'Standard Chartered Bank Malaysia Berhad',
                'bank_code' => 'SCB',
                'bic_code' => 'SCBLMYKX',
            ],
            [
                'bank_name' => 'Sumitomo Mitsui Banking Corporation (M) Berhad',
                'bank_code' => 'SMBC',
                'bic_code' => 'SMBCMYKL',
            ],
            [
                'bank_name' => 'Touch `n Go eWallet',
                'bank_code' => 'TNGD',
                'bic_code' => 'TNGDMYNB',
            ],
            [
                'bank_name' => 'United Overseas Bank Berhad (UOB)',
                'bank_code' => 'UOB',
                'bic_code' => 'UOVBMYKL',
            ],
            [
                'bank_name' => 'Axiata Digital Ecode Sdn Bhd',
                'bank_code' => 'BOOST',
                'bic_code' => 'BOSTMYNB',
            ],
        ];

        foreach ($codes as $data) {
            BICCode::updateOrCreate([
                'bic_code' => $data['bic_code'],
            ], $data);
        }

        return self::SUCCESS;
    }
}
