<?php

namespace ZarulIzham\AutoDebit;

use ZarulIzham\AutoDebit\Messages\AuthenticationRequest;
use ZarulIzham\AutoDebit\Messages\ConsentEnquiry;
use ZarulIzham\AutoDebit\Messages\ConsentRegistration;
use ZarulIzham\AutoDebit\Messages\ConsentTermination;
use ZarulIzham\AutoDebit\Messages\DebitInquiry;
use ZarulIzham\AutoDebit\Messages\DebitRequest;

class AutoDebit
{
    public function authenticate()
    {
        $request = new AuthenticationRequest();

        $request->authorize();

        return [
            'status' => $request->status(),
            'token' => $request->getToken(),
        ];
    }

    public function register(array $data, $registrationable = null, $userable = null)
    {
        $request = new ConsentRegistration();

        return $request->register($data, $registrationable, $userable);
    }

    public function enquiry(string $consentId)
    {
        $request = new ConsentEnquiry();

        return $request->enquiry($consentId);
    }

    public function debit(array $data)
    {
        $request = new DebitRequest();

        return $request->debit($data);
    }

    public function debitInquiry(array $data)
    {
        $request = new DebitInquiry();

        return $request->inquiry($data);
    }

    public function terminate(array $data)
    {
        $consent = new ConsentTermination();

        return $consent->terminate($data);
    }
}
