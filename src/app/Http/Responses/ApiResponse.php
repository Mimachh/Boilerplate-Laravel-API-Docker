<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;

class ApiResponse implements Responsable
{
    protected int $httpCode;
    protected array $data;
    protected string $errorMessage;

    public function __construct(int $httpCode, array $data = [], string $errorMessage = '')
    {

        if(! (($httpCode >= 200 && $httpCode <= 300) || ($httpCode >= 400 && $httpCode <= 600))) {
            throw new \RuntimeException($httpCode . ' is not a valid HTTP code');
        }

        $this->httpCode = $httpCode;
        $this->data = $data;
        $this->errorMessage = $errorMessage;

        // $this->send();
    }

    public function toResponse($request): \Illuminate\Http\JsonResponse
    {
        $payload = match (true) {
            $this->httpCode >= 500 => ['error_message' => $this->errorMessage],
            $this->httpCode >= 400 => ['error_message' => $this->errorMessage],
            $this->httpCode >= 200 => ['data' => $this->data],
        };
        return response()->json(
            data: $payload,
            status: $this->httpCode,
            options: JSON_UNESCAPED_UNICODE
        );
    }

    public static function ok(array $data) {
        return new static(200, $data);
    }

    public static function created(array $data) {
        return new static(201, $data);
    }

    public static function notFound(string $errorMessage = "Item not found") {
        return new static(404, errorMessage: $errorMessage);
    }

    public static function forbidden(string $errorMessage = "Forbidden") {
        return new static(403, errorMessage: $errorMessage);
    }
}