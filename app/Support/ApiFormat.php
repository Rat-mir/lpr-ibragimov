<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

class ApiFormat
{
    public static function success(
        mixed $data,
        int $status = 200,
        array $extra = []
    ): JsonResponse {
        return response()->json(
            array_merge([
                'status' => 'ok',
                'result' => $data,
                'student' => config('lab.slug'),
                'lesson' => config('lab.code'),
            ], $extra),
            $status,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }

    public static function error(
        string $message,
        int $status,
        array $fields = []
    ): JsonResponse {
        $body = [
            'status' => 'error',
            'httpCode' => $status,
            'message' => $message,
            'details' => $fields,
        ];

        return response()->json(
            $body,
            $status,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}