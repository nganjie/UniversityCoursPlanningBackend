<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Admin\AddRoleAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{

    public function current(){
        try{
            $admin=Admin::find(auth()->user()->id);
            return ApiResponse::success($admin);
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function update(UpdateAdminRequest $request,Admin $admin){
        try{
            //$admin=Admin::find(auth()->user()->id);
            $validated= $request->validated();
            $admin->update($validated);
            return ApiResponse::success($admin);
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function all(Request $request){
        try{
            $admins=Admin::paginate($request->input('per_page',4));
            return ApiResponse::success($admins);
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error(message: $e->getMessage(),$e));
        }
    }
    public function addRole(AddRoleAdminRequest $request,Admin $admin){
        try{
            $validated= $request->validated();
            return $admin;
            $role=Role::where('name',$validated["role"]);
            //return $role;
            $admin->assignRole($role);
            return ApiResponse::success($admin);
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
}
