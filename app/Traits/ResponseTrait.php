<?php

namespace App\Traits;

trait ResponseTrait
{
    public function apiResponse($data, $message = '',$status = 200, $errors = [])
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'errors' => $errors,
            'status' => $status
        ],$status);
    }
}
