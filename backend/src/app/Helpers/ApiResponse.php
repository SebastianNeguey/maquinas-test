<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data = null, $message = 'OK', $code = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function error($message = 'Error', $code = 500, $errors = null)
    {
        return response()->json([
            'message' => $message,
            'error' => $errors,
        ], $code);
    }
}
