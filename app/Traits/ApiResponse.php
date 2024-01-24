<?php

namespace App\Traits;

trait ApiResponse
{
    public function jsonResponse($status=200,$message=null,$data=null): \Illuminate\Http\JsonResponse
    {
        $response=[
            'status'=>$status,
            'message'=>$message,
            'data'=>$data
        ];
        return response()->json($response,$status);
    }
}
