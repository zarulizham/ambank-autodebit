<?php

namespace ZarulIzham\AutoDebit\Messages;

use Illuminate\Support\Facades\Http;
use ZarulIzham\AutoDebit\Traits\HasAuthorizedHeader;
use ZarulIzham\AutoDebit\Traits\HasHttpResponse;
use ZarulIzham\AutoDebit\Traits\HasSignature;

class ConsentEnquiry
{
    use HasAuthorizedHeader;
    use HasHttpResponse;
    use HasSignature;

    public function enquiry(string $consentId)
    {
        $this->commonHeader();

        $url = config('autodebit.url').'/api/EConsent/v1.0/ConsentEnquiry/'.$this->sourceReferenceNumber;

        $body = [
            'consentId' => $consentId,
        ];

        $headers['Ambank-Signature'] = $this->signature('/api/EConsent/v1.0/ConsentEnquiry/'.$this->sourceReferenceNumber, $this->ambankTimestamp, $body);

        $this->response = Http::withHeaders($headers)
            ->withOptions([
                'debug' => false,
            ])
            ->withBody(json_encode($body), 'application/json')
            ->post($url);

        return $this;
    }
}
