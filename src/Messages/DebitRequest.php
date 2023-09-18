<?php

namespace ZarulIzham\AutoDebit\Messages;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use ZarulIzham\AutoDebit\Models\AutodebitDebitTransaction;
use ZarulIzham\AutoDebit\Traits\HasAuthorizedHeader;
use ZarulIzham\AutoDebit\Traits\HasHttpResponse;
use ZarulIzham\AutoDebit\Traits\HasSignature;

class DebitRequest
{
    use HasHttpResponse;
    use HasSignature;
    use HasAuthorizedHeader;

    public AutodebitDebitTransaction $debitTransaction;

    public function debit(array $data)
    {
        $this->validate($data);

        $headers = $this->commonHeader();

        $url = config('autodebit.url').'/api/EConsent/v1.0/RTD/'.$this->sourceReferenceNumber;

        $body = array_merge($data, [
            'merchantId' => config('autodebit.merchant_id'),
            'productId' => config('autodebit.product_id'),
        ]);

        $this->storeTransaction($data, $body);

        $headers['Ambank-Signature'] = $this->signature('/api/EConsent/v1.0/RTD/'.$this->sourceReferenceNumber, $this->ambankTimestamp, $body);

        $this->response = Http::withHeaders($headers)
            ->withOptions([
                'debug' => false,
            ])
            ->withBody(json_encode($body), 'application/json')
            ->post($url);

        $this->updateTransaction();

        return $this;
    }

    private function validate($data)
    {
        return Validator::make($data, [
            'amount' => 'required|string|max:14',
            'consentRegId' => 'required|string',
            'gpsCoordinate' => 'required|string|max:35',
            'billRefNo' => 'required|string|max:140',
            'billDesc' => 'nullable|string|max:140',
        ])->validate();
    }

    private function storeTransaction(array $data, array $body)
    {
        $this->debitTransaction = AutodebitDebitTransaction::create([
            'consent_id' => $data['consentRegId'],
            'amount' => $data['amount'],
            'bill_ref_no' => $data['billRefNo'],
            'bill_description' => $data['billDesc'],
            'debit_status' => 'PNDG',
            'request_body' => $body,
        ]);
    }

    private function updateTransaction()
    {
        $this->debitTransaction->update([
            'debit_status' => $this->response->json()->requestStatus,
            'reason_code' => $this->response->json()->reasonCode,
            'reason_detail' => $this->response->json()->reasonDetail,
            'debit_account_id' => $this->response->json()->debtAcctId,
            'response_body' => $this->response->json(),
        ]);
    }
}
