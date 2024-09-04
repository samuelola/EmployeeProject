<?php
namespace App\Library;

class Utilities
{

    public static function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
 
        return response()->json($response, 200);
    }

    public static function sendError($error, $errorMessages = [], $code = 401)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];
 
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }
 
        return response()->json($response, $code);
    }

     public static function logoutResponse($message)
    {
    	$response = [
            'success' => true,
            'message' => $message,
        ];
 
        return response()->json($response, 201);
    }

    public static function notFoundResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
 
        return response()->json($response, 404);
    }
}

?>