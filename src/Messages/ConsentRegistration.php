<?php

namespace ZarulIzham\AutoDebit\Messages;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use ZarulIzham\AutoDebit\Models\Consent;
use ZarulIzham\AutoDebit\Traits\HasAuthorizedHeader;
use ZarulIzham\AutoDebit\Traits\HasHttpResponse;
use ZarulIzham\AutoDebit\Traits\HasSignature;
use ZarulIzham\AutoDebit\Traits\ParseResponse;

class ConsentRegistration
{
    use HasAuthorizedHeader;
    use HasHttpResponse;
    use HasSignature;
    use ParseResponse;

    private $debitable;

    private $userable;

    public Consent $consent;

    public function register(array $data, $debitable = null, $userable = null)
    {
        $this->debitable = $debitable;
        $this->userable = $userable;

        $data = $this->validate($data);

        $headers = $this->commonHeader();

        $url = config('autodebit.url').'/api/EConsent/v1.0/ConsentReg/'.$this->sourceReferenceNumber;

        $body = array_merge($data, [
            'consentReqExpDate' => now()->addDays(7)->format('Y-m-d'),
            'effectiveDate' => now()->format('Y-m-d'),
            'merchantId' => config('autodebit.merchant_id'),
            'productId' => config('autodebit.product_id'),
        ]);

        $headers['Ambank-Signature'] = $this->signature('/api/EConsent/v1.0/ConsentReg/'.$this->sourceReferenceNumber, $this->ambankTimestamp, $body);

        $this->response = Http::withHeaders($headers)
                ->withOptions([
                    'debug' => false,
                ])
                ->withBody(json_encode($body), 'application/json')
                ->post($url);

        $this->saveResponse($data);

        $this->parseResponse();

        return $this;
    }

    protected function validate($data)
    {
        $data = return Validator::make($data, [
            'debtorSourceOfFund' => 'required|in:01,02,03',
            'debtorName' => 'required|string|max:140',
            'debtorAgentBIC' => 'required|string|max:8',
            'debtorIdType' => 'required|string|in:01,02,03,04,05',
            'debtorIdNo' => 'required|string|max:140',
            'debtorAcctId' => 'required|string|max:34',
            'debtorAcctType' => 'required|in:CACC,SVGS,PRXY,CCRD,WALL',
            'maxAmount' => 'required|numeric',
            'consentFreq' => 'required|string|in:01,02,03,04,05,06',
            'consentId' => 'nullable|string|max:34',
            'expiryDate' => 'required|date|date_format:Y-m-d',
            'billRefNo' => 'required|string|max:140',
            'billDesc' => 'nullable|string|max:140',
        ], [
            'debtorSourceOfFund' => __('source of fund'),
            'debtorAgentBIC' => __('debiting bank'),
            'debtorIdType' => __('identity type'),
            'debtorIdNo' => __('identity number'),
            'debtorAcctType' => __('account type'),
            'consentFreq' => __('consent frequency'),
        ])->validate();

        $data['maxAmount'] = number_format($data['maxAmount'], 2, '.', '');

        return $data;
    }

    private function saveResponse($requestBody)
    {
        $data = [
            'request_body' => $requestBody,
            'response_body' => $this->response->json(),
            'max_amount' => $requestBody['maxAmount'],
            'consent_frequency' => $requestBody['consentFreq'],
        ];

        if ($this->response->status() == 200) {
            $data['consent_id'] = $this->response->object()->consentId;
            $data['consent_status'] = $this->response->object()->consentStatus;
        } else {
            $data['consent_status'] = 'FAIL';
        }

        $this->consent = Consent::create($data);

        if ($this->debitable) {
            $this->consent->debitable()->associate($this->debitable);
        }

        if ($this->userable) {
            $this->consent->userable()->associate($this->userable);
        }

        $this->consent->save();
    }
}
