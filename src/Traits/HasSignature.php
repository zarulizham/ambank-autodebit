<?php

namespace ZarulIzham\AutoDebit\Traits;

trait HasSignature
{
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

        $stringToHashBase64 = base64_encode($headerString).'.'.base64_encode($bodyString);
        $stringToHashBase64 = str_replace('=', '', $stringToHashBase64);

        $hash_hmac = hash_hmac('sha256', $stringToHashBase64, config('autodebit.api_secret'));
        $signatureHex = hex2bin($hash_hmac);
        $base64 = str_replace('=', '', base64_encode($signatureHex));

        return $base64;
    }
}
