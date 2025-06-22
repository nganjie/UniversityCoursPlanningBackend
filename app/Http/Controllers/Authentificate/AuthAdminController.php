<?php

namespace App\Http\Controllers\Authentificate;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Admin\RegisterAdminRequest;
use App\Http\Requests\AdminLoginRequest;
use App\Models\Admin;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthAdminController extends Controller
{
    public function register(RegisterAdminRequest $request){
        $validated= $request->validated();
        try{
             $validated['password'] = Hash::make($validated['password']);
            $admin=Admin::create($validated);
            return ApiResponse::created($admin);

        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error('something went wrong',$e));
        }

    }
    public function login(AdminLoginRequest $request){
        //$validator=
        try{
            $validated=$request->validated();
            $admin=Admin::where('email',$validated['email'])->first();
            if(Auth::attempt($request->only(["email","password"]))){
                $token = $admin->createToken('admin-course-planning')->plainTextToken;
                return ApiResponse::success($admin,$token);
            }else{
                return ApiResponse::error(__('incorrect identifiers'));
            }

        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error('something went wrong',$e));
        }
    }
}
