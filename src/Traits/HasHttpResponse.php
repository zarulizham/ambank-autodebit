<?php

namespace ZarulIzham\AutoDebit\Traits;

trait HasHttpResponse
{
    private $response;

    public function json()
    {
        return $this->response->json() ?? [];
    }

    public function body(): string
    {
        return $this->response->body() ?? '';
    }

    public function status(): int
    {
        return $this->response->status() ?? 0;
    }
}
