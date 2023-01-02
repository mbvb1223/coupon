<?php

namespace App\Http\Responses;

class SuccessResponse extends AbstractResponse
{
    protected $success = true;
    protected $code = 200;
}
