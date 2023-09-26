<?php

namespace ZarulIzham\AutoDebit\Messages;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use ZarulIzham\AutoDebit\Models\AutoDebitDebitTransaction;
use ZarulIzham\AutoDebit\Traits\HasAuthorizedHeader;
use ZarulIzham\AutoDebit\Traits\HasHttpResponse;
use ZarulIzham\AutoDebit\Traits\HasSignature;
use ZarulIzham\AutoDebit\Traits\ParseResponse;

class DebitRequest
{
    use HasAuthorizedHeader;
    use HasHttpResponse;
    use HasSignature;
    use ParseResponse;

    public AutoDebitDebitTransaction $debitTransaction;

    public function debit(array $data)
    {
        $data = $this->validate($data);

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

        $this->parseResponse();

        $this->updateTransaction();

        return $this;
    }

    private function validate($data)
    {
        $data = Validator::make($data, [
            'amount' => 'required|numeric',
            'consentRegId' => 'required|string',
            'billRefNo' => 'required|string|max:140',
            'billDesc' => 'nullable|string|max:140',
        ])->validate();

        $data['amount'] = number_format($data['amount'], 2, '.', '');
        $data['gpsCoordinate'] = config('autodebit.gps_coordinate');

        return $data;
    }

    private function storeTransaction(array $data, array $body)
    {
        $this->debitTransaction = AutoDebitDebitTransaction::create([
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
            'debit_status' => $this->response->object()->requestStatus,
            'reason_code' => $this->response->object()->reasonCode,
            'reason_detail' => $this->response->object()->reasonDetail,
            'debit_account_id' => $this->response->object()->debtAcctId,
            'debited_at' => $this->response->object()->creationDate,
            'response_body' => $this->response->json(),
        ]);
    }
}
