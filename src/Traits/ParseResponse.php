<?php

namespace ZarulIzham\AutoDebit\Traits;

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
        }
    }
}
