<?php

use App\Http\Controllers\Authentificate\AuthAdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/**
 * @OA\Info(
 *   version="1.0",
 *     
 *   title=" API Documentation",
 *   descrption="API documentation for version 1.0 endpoints.",
 *   
 *   @OA\Contact(
 *     email="test@mail.com"
 *   ),
 * )
 * @OA\Get(
 *   path="/",
 *   summary="Health-check endpoint"
 *   
 *   @OA\Response(response=200, description="OK")
 * )
 */
Route::get("test", function (Request $request) {
    return [
        "app"=>125
    ];
});
Route::post("create-admin",[AuthAdminController::class,"register"]);
Route::post("admin-login",[AuthAdminController::class,"login"]);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
