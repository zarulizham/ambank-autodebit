<?php

namespace ZarulIzham\AutoDebit;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AutoDebit
{
    public function authenticate()
    {
        $url = config('autodebit.url') . '/api/oauth/v2.0/token';

        $response = Http::asForm()
            ->withBasicAuth(config('autodebit.client_id'), config('autodebit.client_secret'))
            ->withHeaders([
                'ClientID' => config('autodebit.client_id'),
            ])->post($url, [
                    'grant_type' => 'client_credentials',
                    'scope' => 'resource.READ,resource.WRITE',
                ]);

        if (isset($response->object()->ResponseCode)) {
            throw new \Exception($response->object()->ResponseMessage, 400);
        }

        return $response->object()->access_token;
    }

    protected function getSrcRefNo()
    {
        $sequence = str_pad(Cache::increment('autodebit_sequence'), 6, "0", STR_PAD_LEFT);

        return config('autodebit.prefix_id') . date('dmY') . $sequence;
    }

    public function register(array $data)
    {
        $this->validate($data);
        $token = Cache::remember('duitnow_qr_token', config('autodebit.token_expiry'), fn() => $this->authenticate());

        $sourceReferenceNumber = $this->getSrcRefNo();
        $ambankTimestamp = now()->format('dmYHis');
        $url = config('autodebit.url') . '/api/EConsent/v1.0/ConsentReg/' . $sourceReferenceNumber;

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Authentication' => 'Bearer ' . $token,
            'AmBank-Timestamp' => $ambankTimestamp,
            'Channel-Token' => config('autodebit.channel_token'),
            'Channel-APIKey' => config('autodebit.api_key'),
            'srcRefNo' => $sourceReferenceNumber,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $body = array_merge($data, [
            'merchantId' => config('autodebit.merchant_id'),
            'productId' => config('autodebit.product_id'),
        ]);

        $headers['Ambank-Signature'] = $this->signature('/api/EConsent/v1.0/ConsentReg/' . $sourceReferenceNumber, $ambankTimestamp, $body);

        $response = Http::withHeaders($headers)
            ->withOptions([
                'debug' => false,
            ])
            ->withBody(json_encode($body), 'application/json')
            ->post($url);

        // $this->saveTransaction($body, $response['QRString'], $response['QRCode'], $sourceReferenceNumber, $referenceId);

        dd([
            'url' => $url,
            'request_headers' => $headers,
            'request_body' => $body,
            // 'response_header' => $response->getHeaders(),
            'response_code' => $response->status(),
            'response_body' => $response->json(),
        ]);
        return $response->json();
    }

    protected function validate($data)
    {
        return Validator::make($data, [
            'debtorSourceOfFund' => 'required|in:01,02,03',
            'debtorName' => 'required|string|max:140',
            'debtorAgentBIC' => 'required|string|max:8',
            'debtorIdType' => 'required|string|in:01,02,03,04,05',
            'debtorIdNo' => 'required|string|max:140',
            'debtorAcctId' => 'required|string|max:34',
            'debtorAcctType' => 'required|in:CACC,SVGS,PRXY,CCRD,WALL',
            'maxAmount' => 'required|string|max:14',
            'consentFreq' => 'required|string|in:01,02,03,04,05,06',
            'consentId' => 'nullable|string|max:34',
            'effectiveDate' => 'required|date|date_format:Y-m-d',
            'expiryDate' => 'required|date|date_format:Y-m-d',
            'consentReqExpDate' => 'required|date',
            'billRefNo' => 'required|string|max:140',
            'billDesc' => 'nullable|string|max:140',
        ])->validate();
    }

    public function signature($uri, $ambankTimestamp, $body): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
            'uri' => $uri,
            'iat' => $ambankTimestamp,
        ];

        $headerString = preg_replace('/\s+/', '', json_encode($header, JSON_UNESCAPED_SLASHES));
        $bodyString = preg_replace('/\s+/', '', json_encode($body, JSON_UNESCAPED_SLASHES));

        $stringToHashBase64 = base64_encode($headerString) . '.' . base64_encode($bodyString);
        $stringToHashBase64 = str_replace('=', '', $stringToHashBase64);

        $hash_hmac = hash_hmac('sha256', $stringToHashBase64, config('autodebit.api_secret'));
        $signatureHex = hex2bin($hash_hmac);
        $base64 = str_replace('=', '', base64_encode($signatureHex));

        return $base64;
    }
}