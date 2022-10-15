<?php

namespace App;

trait ResponseTrait
{
    public function apiResponse($data, $message = '',$status = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status
        ],$status);
    }
}
