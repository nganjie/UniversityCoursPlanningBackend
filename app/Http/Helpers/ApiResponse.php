<?php

namespace App\Http\Helpers;

use function Laravel\Prompts\error;

class ApiResponse{
    public static function unauthorized($data, $message = null)
    {
        return response()->json([ 'data' => $data, 'message' => $message,'success'=>false,"error_code"=>401,"errors"=>null], 401);
    }
    public static function success($data,$message = null)
    {
        return response()->json( [ 'message' => $message,'data' => $data,'success'=>true,"error_code"=>200,"errors"=>null], 200);
    }
    public static function onlysuccess($message = null)
    {
        return response()->json([ 'message' => $message,'success'=>true], 200);
    }

    public static function no_content($message = 'No Data Found')
    {
        return response()->json(['data' => null, 'message' => $message,'success'=>false,"error_code"=>204,"errors"=>null], 204);
    }

    public static function created($data = [],$message = 'Data')
    {
        return response()->json([ 'message' => $message." Created successfully", 'data' => $data,'success'=>true,"error_code"=>200,"errors"=>null], 201);
    }

    public static function updated($message = 'Data Updated', $data = null)
    {
        return response()->json(['message' => $message,'data' => $data,'success'=>true,"error_code"=>200,"errors"=>null], 202);
    }

    public static function deleted($message = 'Data Deleted', $data = null)
    {
        return response()->json(['data' => $data, 'message' => $message,"error_code"=>200,"errors"=>null], 202);
    }

    public static function error($message = 'Something Went Wrong', $data = null)
    {
        return response()->json(['data' => $data, 'message' => $message,'success'=>false,"error_code"=>400,"errors"=>null],400);
    }

    public static function validation($message = 'Invalid Submission', $data = null)
    {
        return response()->json(['data' => $data, 'message' => $message,'success'=>false,"error_code"=>422,"errors"=>null], 422);
    }
    public static function maintenance($message = 'Something Went Wrong', $data = null)
    {
        return response()->json(['message' => $message,'data' => $data,'success'=>true,"error_code"=>503,"errors"=>null], 503);
    }
    public static function exception($message,$errors,$status)
    {
        return response()->json(['message' => $message,'data' => null,'success'=>false,"error_code"=>$status,"errors"=>$errors], $status);
    }
}