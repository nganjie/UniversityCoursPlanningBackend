<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Authentificate\AuthAdminController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
Route::get("permission_role",function(){
    $permission=Permission::create(["name"=>"all","guard_name"=>"api"]);
    $permissionSemis=Permission::create(["name"=> "semis all","guard_name"=>"api"]);
    $role1= Role::create(["name"=> "Technical-Support","guard_name"=>"api"]);
    $role1->givePermissionTo($permission);
    $role2= Role::create(["name"=> "chef-etablissement","guard_name"=>"api"]);
    $role2->givePermissionTo($permissionSemis);
    return [$role1,$role2];
});
Route::prefix("auth")->name("auth.")->group(function () {
    Route::prefix("admin/")->name("admin.")->group(function () {
          Route::post("create",[AuthAdminController::class,"register"]);
    Route::post("login",[AuthAdminController::class,"login"]);
    });
    Route::prefix("enseignants/")->name("enseignant.")->group(function () {
          Route::post("create",[AuthAdminController::class,"register"]);
    Route::post("login",[AuthAdminController::class,"login"]);
    });
  
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:enseignants');

Route::middleware('auth:admins')->name('admins.')->prefix('admins/')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('current','current')->name("current");
        Route::put('update/{admin}','update');
        Route::post('add-role/{admin}','addRole')->name('add.role');
        Route::get('all','all')->name('all');
    });
});