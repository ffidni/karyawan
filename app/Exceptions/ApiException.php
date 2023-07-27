<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ApiException extends Exception
{

    protected $data;
    protected $statusCode;

    public function __construct($statusCode, $message = "", $data = null, $code = 0, Throwable $previous = null)
    {
        $this->statusCode = $statusCode;
        $this->data = $data;
        parent::__construct($message, $code, $previous);
    }

    public function getData()
    {
        return $this->data;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }


}