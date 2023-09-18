<?php

namespace ZarulIzham\AutoDebit\Messages;

use Illuminate\Support\Facades\Http;
use ZarulIzham\AutoDebit\Traits\HasAuthorizedHeader;
use ZarulIzham\AutoDebit\Traits\HasHttpResponse;
use ZarulIzham\AutoDebit\Traits\HasSignature;
use ZarulIzham\AutoDebit\Traits\HasSrcRefNo;

class ConsentEnquiry
{
    use HasSignature;
    use HasHttpResponse;
    use HasAuthorizedHeader;

    public function enquiry(string $consentId)
    {
        $this->commonHeader();

        $url = config('autodebit.url').'/api/EConsent/v1.0/ConsentReg/'.$this->sourceReferenceNumber;

        $body = [
            'consentId' => $consentId,
        ];

        $headers['Ambank-Signature'] = $this->signature('/api/EConsent/v1.0/ConsentReg/'.$this->sourceReferenceNumber, $this->ambankTimestamp, $body);

        $this->response = Http::withHeaders($headers)
            ->withOptions([
                'debug' => false,
            ])
            ->withBody(json_encode($body), 'application/json')
            ->post($url);

        return $this;
    }
}
