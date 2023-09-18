<?php

namespace ZarulIzham\AutoDebit\Traits;

use ZarulIzham\AutoDebit\Messages\AuthenticationRequest;

trait HasAuthorizedHeader
{
    use HasSrcRefNo;

    private $sourceReferenceNumber;

    private $ambankTimestamp;

    public function commonHeader()
    {
        $authenticationRequest = new AuthenticationRequest();
        $token = $authenticationRequest->getToken();

        $this->sourceReferenceNumber = $this->getSrcRefNo();
        $this->ambankTimestamp = now()->format('dmYHis');

        return [
            'Authorization' => 'Bearer '.$token,
            'Authentication' => 'Bearer '.$token,
            'AmBank-Timestamp' => $this->ambankTimestamp,
            'Channel-Token' => config('autodebit.channel_token'),
            'Channel-APIKey' => config('autodebit.api_key'),
            'srcRefNo' => $this->sourceReferenceNumber,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
