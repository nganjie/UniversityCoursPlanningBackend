<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Admin\RegisterEnseignantRequest;
use App\Models\Admin;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class AdminEnseignant extends Controller
{
    public function registerEnseignant(RegisterEnseignantRequest $request,Admin $admin){
        try{
            $validated= $request->validated();
            
            return ApiResponse::success($admin);
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
}
