<?php

namespace App\Http\Controllers\Authentificate;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\LoginEnseignantRequest;
use App\Models\Enseignant;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthEnseignantController extends Controller
{
   public function login(LoginEnseignantRequest $request)
    {
        // Logic to authenticate a student
        try {
            $validated = $request->validated();
            $enseignant = Enseignant::where('email', $validated['email'])->first();
            if ($enseignant && Hash::check($validated['password'], $enseignant->password)) {
                // Assuming you have a method to create a token or session
                 $token = $enseignant->createToken('student-course-planning')->plainTextToken;

                return ApiResponse::success($enseignant, $token);
            } else {
                return ApiResponse::error(__('incorrect identifiers'));
            }
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error('something went wrong', $e));
        }
        // Validate credentials and return a token or session
    }
}
