<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelpers
{
    /**
     * Helper untuk format response JSON.
     */
    // public static function sendResponse( $status = "success", $data = null, $message = "Success"): JsonResponse
    // {
    //     return response()->json([
    //         'status' => $status,
    //         'message' => $message,
    //         'data' => $data
    //     ]);
    // }

    //ada static agar lebih menyingkatkan code tanpa perlu membuat code baru untuk membuat response
    public static function jsonResponse( $status, $message = null, $data =null ,int $code = null){
        $res = [ 'status' => $status];
        /*

        */
        if(!is_null($data)) {
            $res['data'] = $data;
        }
        if(!is_null($message)) {
            $res['message'] = $message;
        }
        return response()->json($res, $code);
    }
}
