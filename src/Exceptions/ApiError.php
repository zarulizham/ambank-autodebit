<?php

namespace ZarulIzham\AutoDebit\Exceptions;

use Exception;

class ApiError extends Exception
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        return false;
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            'message' => $this->message,
        ], 500);
    }
}
