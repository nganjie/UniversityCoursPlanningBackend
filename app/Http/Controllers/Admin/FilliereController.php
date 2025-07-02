<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Filiere\RegisterFiliereRequest;
use App\Http\Requests\Filiere\UpdateFiliereRequest;
use App\Models\Etablissement;
use App\Models\Filliere;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class FilliereController extends Controller
{
    public function register(RegisterFiliereRequest $request,Etablissement $etablissement)
    {
        try{
            $validated = $request->validated();
            // Assuming you have a model for Etablissement and it has a relation with Filiere
            $filiere = $etablissement->fillieres()->create($validated);
            return ApiResponse::created($filiere, "Filiere");
        }catch(\Exception $e){
             throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to register a new filiere
    }

    public function update(UpdateFiliereRequest $request,Filliere $filiere)
    {
        try{
            $validated = $request->validated();
            // Assuming you have a model for Filiere and it can be updated
            $filiere->update($validated);
            return ApiResponse::success($filiere, "Filiere updated successfully");
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to update an existing filiere
    }

    public function all(Request $request)
    {
        try{
            if($request->has('search')){
                $search = $request->input('search');
                // Assuming you have a searchable field in Filiere model
                $fillieres = Filliere::where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->paginate($request->input('per_page', 10));
                return ApiResponse::success($fillieres, "Search Results for Fillieres");
            }else{
                $fillieres = Filliere::paginate($request->input('per_page', 10));
                // If no search term, return all fillieres
            }
            
            return ApiResponse::success($fillieres, "All Fillieres");
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to get all fillieres
    }

    public function allFillieresEtablissement(Etablissement $etablissement)
    {
        try{
            if(request()->has('search')){
                $search = request()->input('search');
                $fillieres = $etablissement->fillieres()
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->paginate(request()->get('per_page', 10));
                return ApiResponse::success($fillieres, "Search Results for Fillieres in Etablissement");
            }
            $fillieres = $etablissement->fillieres()->paginate(request()->get('per_page', 10));
            return ApiResponse::success($fillieres, "All Fillieres for Etablissement");
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to get all fillieres for a specific etablissement
    }

    public function detail(Filliere $filiere)
    {
        try{
            return ApiResponse::success($filiere, "Filiere details");
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        
        // Logic to get details of a specific filiere
    }
}
