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
                'is_active' => false,
            ],
            [
                'bank_name' => 'Alliance Bank Malaysia Berhad',
                'bank_code' => 'ABMB',
                'bic_code' => 'MFBBMYKL',
                'is_active' => true,
            ],
            [
                'bank_name' => 'Al-Rajhi',
                'bank_code' => 'ARM',
                'bic_code' => 'RJHIMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Ambank Malaysia Berhad',
                'bank_code' => 'AMFB',
                'bic_code' => 'ARBKMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Bank Islam Malaysia Berhad',
                'bank_code' => 'BIMB',
                'bic_code' => 'BIMBMYKL',
                'is_active' => true,
            ],
            [
                'bank_name' => 'Bank Kerjasama Rakyat Malaysia Berhad',
                'bank_code' => 'BKRB',
                'bic_code' => 'BKRMMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Bank Muamalat Malaysia Bhd',
                'bank_code' => 'BMMB',
                'bic_code' => 'BMMBMYKL',
                'is_active' => true,
            ],
            [
                'bank_name' => 'Bank Pertanian Malaysia Berhad (Agrobank)',
                'bank_code' => 'BPM',
                'bic_code' => 'AGOBMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Bank of America (M) Berhad',
                'bank_code' => 'BOA',
                'bic_code' => 'BOFAMY2X',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Bank of China (M) Berhad',
                'bank_code' => 'BOCM',
                'bic_code' => 'BKCHMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Bank Simpanan Nasional Berhad',
                'bank_code' => 'BSNB',
                'bic_code' => 'BSNAMYK1',
                'is_active' => false,
            ],
            [
                'bank_name' => 'BNP Paribas Malaysia Berhad',
                'bank_code' => 'BNP',
                'bic_code' => 'BNPAMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'CIMB Bank Berhad',
                'bank_code' => 'CIMB',
                'bic_code' => 'CIBBMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'China Construction Bank (M) Berhad',
                'bank_code' => 'PCBC',
                'bic_code' => 'PCBCMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Citibank Berhad',
                'bank_code' => 'CITI',
                'bic_code' => 'CITIMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Deutsche Bank (Malaysia) Berhad',
                'bank_code' => 'DB',
                'bic_code' => 'DEUTMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Finexus Cards Sdn. Bhd.',
                'bank_code' => 'FIN',
                'bic_code' => 'FNXSMYNB',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Hong Leong Bank Berhad',
                'bank_code' => 'HLB',
                'bic_code' => 'HLBBMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'HSBC Bank Malaysia Berhad',
                'bank_code' => 'HSBC',
                'bic_code' => 'HBMBMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Industrial and Commercial Bank of China (M) Berhad',
                'bank_code' => 'ICB',
                'bic_code' => 'ICBKMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'JP Morgan Chase Bank Berhad',
                'bank_code' => 'JPMC',
                'bic_code' => 'CHASMYKX',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Kuwait Finance House',
                'bank_code' => 'KFH',
                'bic_code' => 'KFHOMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Maybank Berhad',
                'bank_code' => 'MBB',
                'bic_code' => 'MBBEMYKL',
                'is_active' => true,
            ],
            [
                'bank_name' => 'MBSB Bank Berhad',
                'bank_code' => 'MBSB',
                'bic_code' => 'AFBQMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Mizuho Bank (Malaysia) Berhad',
                'bank_code' => 'MCBM',
                'bic_code' => 'MHCBMYKA',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Bank of Tokyo-Mitsubishi UFJ (M) Berhad',
                'bank_code' => 'BOTM',
                'bic_code' => 'BOTKMYKX',
                'is_active' => false,
            ],
            [
                'bank_name' => 'OCBC Bank Berhad',
                'bank_code' => 'OCBC',
                'bic_code' => 'OCBCMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Public Bank Berhad',
                'bank_code' => 'PBB',
                'bic_code' => 'PBBEMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'RHB Bank Berhad',
                'bank_code' => 'RHB',
                'bic_code' => 'RHBBMYKL',
                'is_active' => true,
            ],
            [
                'bank_name' => 'Standard Chartered Bank Malaysia Berhad',
                'bank_code' => 'SCB',
                'bic_code' => 'SCBLMYKX',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Sumitomo Mitsui Banking Corporation (M) Berhad',
                'bank_code' => 'SMBC',
                'bic_code' => 'SMBCMYKL',
                'is_active' => false,
            ],
            [
                'bank_name' => 'Touch `n Go eWallet',
                'bank_code' => 'TNGD',
                'bic_code' => 'TNGDMYNB',
                'is_active' => false,
            ],
            [
                'bank_name' => 'United Overseas Bank Berhad (UOB)',
                'bank_code' => 'UOB',
                'bic_code' => 'UOVBMYKL',
                'is_active' => true,
            ],
            [
                'bank_name' => 'Axiata Digital Ecode Sdn Bhd',
                'bank_code' => 'BOOST',
                'bic_code' => 'BOSTMYNB',
                'is_active' => false,
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
