<?php

namespace App\Http\Helpers;

use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CommonHelper
{
    function hashSha256(int $length)
    {
        return hash('sha256', Str::random($length));
    }

    function bash64QrCode(string $string)
    {
        return base64_encode(QrCode::format('png')->size(100)->generate($string));
    }
}
