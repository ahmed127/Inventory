<?php

namespace App\Http\Controllers;

abstract class ApiController
{
    public function successResponse($data = [], string $message = 'Success', $status = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function errorResponse($message = 'Error', $status = 400, $errors = [])
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors
        ], $status);
    }
}
