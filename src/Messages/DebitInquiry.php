<?php

namespace ZarulIzham\AutoDebit\Messages;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use ZarulIzham\AutoDebit\Traits\HasAuthorizedHeader;
use ZarulIzham\AutoDebit\Traits\HasHttpResponse;
use ZarulIzham\AutoDebit\Traits\HasSignature;
use ZarulIzham\AutoDebit\Traits\ParseResponse;

class DebitInquiry
{
    use HasAuthorizedHeader;
    use HasHttpResponse;
    use HasSignature;
    use ParseResponse;

    public function inquiry(array $data)
    {
        $this->validate($data);

        $headers = $this->commonHeader();

        $url = config('autodebit.url').'/api/EConsent/v1.0/InquiryStatus/'.$this->sourceReferenceNumber;

        $body = array_merge($data, [
            'merchantId' => config('autodebit.merchant_id'),
        ]);

        $headers['Ambank-Signature'] = $this->signature('/api/EConsent/v1.0/InquiryStatus/'.$this->sourceReferenceNumber, $this->ambankTimestamp, $body);

        $this->response = Http::withHeaders($headers)
            ->withOptions([
                'debug' => false,
            ])
            ->withBody(json_encode($body), 'application/json')
            ->post($url);

        $this->parseResponse();

        return $this;
    }

    private function validate($data)
    {
        return Validator::make($data, [
            'requestId' => 'required|string|max:35',
            'equalDate' => 'required|date|date_format:Y-m-d',
        ])->validate();
    }
}
