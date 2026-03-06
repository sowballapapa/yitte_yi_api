<?php

namespace App\Http\Controllers;


class ResponseController extends Controller
{
    public function success($data, $message = 'Opération réussie', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public function error($message, $code = 400, $errors = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }
}
