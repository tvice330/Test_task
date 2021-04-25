<?php

namespace App\Http\Traits;

trait ResponseTrait
{
    /**
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    static public function okResponse(array $data = [], $code = 200)
    {
        return response()->json([
            'status' => 'ok',
            'data' => $data
        ], $code);
    }

    /**
     * @param array $error
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    static public function badResponse(array $error, $code = 422)
    {
        return response()->json([
            'status' => 'bad request',
            'error' => $error
        ], $code);
    }

    /**
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    static public function notFoundResponse($code = 404)
    {
        return response()->json([
            'status' => 'Not Found'
        ], $code);
    }
}
