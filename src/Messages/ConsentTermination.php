<?php

namespace ZarulIzham\AutoDebit\Messages;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use ZarulIzham\AutoDebit\Models\Termination;
use ZarulIzham\AutoDebit\Traits\HasAuthorizedHeader;
use ZarulIzham\AutoDebit\Traits\HasHttpResponse;
use ZarulIzham\AutoDebit\Traits\HasSignature;

class ConsentTermination
{
    use HasAuthorizedHeader;
    use HasHttpResponse;
    use HasSignature;

    public Termination $termination;

    public function terminate(array $data)
    {
        $this->validate($data);

        $headers = $this->commonHeader();

        $url = config('autodebit.url').'/api/EConsent/v1.0/ConsentTermination/'.$this->sourceReferenceNumber;

        $body = array_merge($data, [
            'merchantId' => config('autodebit.merchant_id'),
            'productId' => config('autodebit.product_id'),
        ]);

        $this->storeTransaction($data);

        $headers['Ambank-Signature'] = $this->signature('/api/EConsent/v1.0/ConsentTermination/'.$this->sourceReferenceNumber, $this->ambankTimestamp, $body);

        $this->response = Http::withHeaders($headers)
            ->withOptions([
                'debug' => false,
            ])
            ->withBody(json_encode($body), 'application/json')
            ->post($url);

        $this->updateTransaction();

        return $this;
    }

    protected function validate($data)
    {
        return Validator::make($data, [
            'consentId' => 'required',
            'reasonFoCancel' => 'required|string|max:256',
        ], [
            'reasonFoCancel' => __('cancellation reason'),
        ])->validate();
    }

    private function storeTransaction($data)
    {
        $this->termination = Termination::create([
            'consent_id' => $data['consentId'],
            'cancellation_reason' => $data['reasonFoCancel'],
        ]);
    }

    private function updateTransaction()
    {
        $this->termination->update([
            'consent_status' => $this->response->json()->consentStatus,
            'request_status' => $this->response->json()->requestStatus,
            'reason_code' => $this->response->json()->reasonCode,
        ]);
    }
}
