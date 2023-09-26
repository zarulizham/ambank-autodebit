<?php

namespace ZarulIzham\AutoDebit\Traits;

use ZarulIzham\AutoDebit\Exceptions\ApiError;
use ZarulIzham\AutoDebit\Exceptions\BadRequest;
use ZarulIzham\AutoDebit\Exceptions\Unauthorized;

trait ParseResponse
{
    protected function parseResponse()
    {
        if (! $this->response) {
            return;
        }

        if ($this->response->status() == 401) {
            throw new Unauthorized($this->response->object()->ResponseMessage);
        } elseif ($this->response->status() == 400) {
            throw new BadRequest($this->response->object()->ResponseMessage);
        } elseif ($this->response->status() == 500) {
            throw new ApiError($this->response->object()->ResponseMessage);
        }
    }
}
