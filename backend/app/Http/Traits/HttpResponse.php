<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponse
{
    /**
     * Return a successful response.
     *
     * @param  array  $data
     * @param  string  $message
     * @param  integer $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success(array $data, array $meta = [], string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'SUCCESS',
            'message' => $message,
            'data' => $data,
            'meta' => $meta
        ], $code);
    }

    /**
     * Return a fail response.
     *
     * @param  array  $data
     * @param  string  $message
     * @param  integer $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error(array $data, string $message = '', int $code = 400): JsonResponse
    {
        return response()->json([
            'status' => 'FAIL',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
