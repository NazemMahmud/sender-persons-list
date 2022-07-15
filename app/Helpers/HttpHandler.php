<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class HttpHandler
{

    /**
     * API success response
     *
     * @param mixed $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function successResponse(mixed $data, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'status' => 'success'
        ], $statusCode);
    }

}
