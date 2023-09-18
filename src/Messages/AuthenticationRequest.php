<?php

namespace ZarulIzham\AutoDebit\Messages;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use ZarulIzham\AutoDebit\Traits\HasHttpResponse;

class AuthenticationRequest
{
    use HasHttpResponse;

    public function authorize()
    {
        $url = config('autodebit.url').'/api/oauth/v2.0/token';

        $this->response = Http::asForm()
            ->withBasicAuth(config('autodebit.client_id'), config('autodebit.client_secret'))
            ->withHeaders([
                'ClientID' => config('autodebit.client_id'),
            ])->post($url, [
                'grant_type' => 'client_credentials',
                'scope' => 'resource.READ,resource.WRITE',
            ]);

        if (isset($this->response->object()->ResponseCode)) {
            throw new \Exception($this->response->object()->ResponseMessage, 400);
        }

        return $this;
    }

    public function getToken(): string
    {
        return Cache::remember('duitnow_qr_token', config('autodebit.token_expiry'), function () {
            $this->authorize();

            return $this->response->object()->access_token;
        });
    }
}
