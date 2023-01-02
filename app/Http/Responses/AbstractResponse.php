<?php

namespace App\Http\Responses;

use JsonSerializable;

class AbstractResponse implements JsonSerializable
{
    protected $success;
    protected $message;
    protected $data;
    protected $code;

    public function __construct(string $message, $data = null, int $code = null)
    {
        $this->message = $message;
        $this->data = $data;
        $this->code = $code ?? $this->code;
    }

    public function jsonSerialize(): array
    {
        return [
            'success' => $this->success,
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }

    public function response()
    {
        return response()->json($this, $this->code);
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getData()
    {
        return $this->data;
    }
}
