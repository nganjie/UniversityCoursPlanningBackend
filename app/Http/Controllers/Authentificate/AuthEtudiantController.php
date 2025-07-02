<?php

namespace App\Http\Controllers\Authentificate;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\LoginEtudiantRequest;
use App\Http\Requests\RegisterEtudiantRequest;
use App\Models\Etablissement;
use App\Models\Etudiant;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthEtudiantController extends Controller
{
    public function register(RegisterEtudiantRequest $request)
    {
        try {
            $validated = $request->validated();
           // $etablissement = Etablissement::find($validated['etablissement_id']) // Ensure etablissement_id is set if required
            $validated['password']=Hash::make($validated['password']);
            $etudiant=Etudiant::create($validated);
            return ApiResponse::created($etudiant, "Etudiant");
            // Logic to create a new student record
            // For example, you might create a new Etudiant model instance and save it to the database
            // $etudiant = Etudiant::create($validated);
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to register a student
        // Validate and create a new student record
    }

    public function login(LoginEtudiantRequest $request)
    {
        // Logic to authenticate a student
        try {
            $validated = $request->validated();
            $etudiant = Etudiant::where('email', $validated['email'])->first();
            if ($etudiant && Hash::check($validated['password'], $etudiant->password)) {
                // Assuming you have a method to create a token or session
                 $token = $etudiant->createToken('student-course-planning')->plainTextToken;

                return ApiResponse::success($etudiant, $token);
            } else {
                return ApiResponse::error(__('incorrect identifiers'));
            }
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error('something went wrong', $e));
        }
        // Validate credentials and return a token or session
    }
}
