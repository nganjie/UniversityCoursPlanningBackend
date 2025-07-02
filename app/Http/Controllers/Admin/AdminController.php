<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Admin\AddRoleAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class AdminController extends Controller
{

    public function current(Request $request){
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
            if($request->has('search')){
                $search = $request->input('search');
                // Assuming you have a searchable field in Admin model
                $admins = Admin::where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->with(['roles','etablissement'])
                    ->paginate($request->input('per_page', 4));
                return ApiResponse::success($admins, "Search Results for Admins");
            }else{
                $admins=Admin::with(['roles','etablissement'])->paginate($request->input('per_page',4));
                // If no search term, return all admins
            }
            
            return ApiResponse::success($admins);
        }catch(\Exception $e){
             throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function addRole(AddRoleAdminRequest $request,Admin $admin){
        try{
            $validated= $request->validated();
            //return $admin;
            $role=Role::where('name',$validated["role"])->first();
            //return $role;
            //return $role;
            $admin->assignRole($role->id);
            return ApiResponse::success($admin->with("roles")->first());
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
}
