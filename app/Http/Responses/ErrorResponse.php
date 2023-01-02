<?php

namespace App\Http\Responses;

class ErrorResponse extends AbstractResponse
{
    protected $success = false;
    protected $code = 500;
}
