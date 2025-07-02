<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Niveau\RegisterSousNiveauRequest;
use App\Http\Requests\Niveau\UpdateSousNiveauRequest;
use App\Models\Niveau;
use App\Models\SousNiveau;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class SousNiveauController extends Controller
{
    public function register(RegisterSousNiveauRequest $request,Niveau $niveau)
    {
        try {
            $validated = $request->validated();
            // Assuming you have a model for SousNiveau and it can be created
            $sousNiveau = $niveau->sousNiveaux()->create($validated);
            return ApiResponse::created($sousNiveau, "Sous-Niveau");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to register a new sous-niveau
        // Validate and create a new sous-niveau for the given niveau
    }

    public function update(UpdateSousNiveauRequest $request,SousNiveau $sousNiveau)
    {
        try {
            $validated = $request->validated();
            
            // Assuming you have a model for SousNiveau and it can be updated
            $sousNiveau->update($validated);
            return ApiResponse::updated("Sous-Niveau", $sousNiveau);
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to update an existing sous-niveau
        // Validate and update the sous-niveau details
    }

    public function all(Request $request)
    {
        try {
            if($request->has('search')){
                $search = $request->input('search');
                // Assuming you have a searchable field in SousNiveau model
                $sousNiveaux = SousNiveau::where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->paginate($request->input('per_page', 10));
                return ApiResponse::success($sousNiveaux, "Search Results for Sous-Niveaux");
            }
            $sousNiveaux = SousNiveau::paginate($request->input('per_page', 10));
            return ApiResponse::success($sousNiveaux, "All Sous-Niveaux");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to get all sous-niveaux
        // Return paginated list of sous-niveaux
    }

    public function allSousNiveauxNiveau(Niveau $Niveau)
    {
        try {
            if(request()->has('search')){
                $search = request()->input('search');
                // Assuming you have a searchable field in SousNiveau model
                $sousNiveaux = $Niveau->sousNiveaux()
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->paginate(request()->input('per_page', 10));
                return ApiResponse::success($sousNiveaux, "Search Results for Sous-Niveaux for Niveau");
            }
            $sousNiveaux = $Niveau->sousNiveaux()->paginate(request()->input('per_page', 10));
            return ApiResponse::success($sousNiveaux, "All Sous-Niveaux for Niveau");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to get all sous-niveaux for a specific niveau
    }

    public function detail(SousNiveau $sousNiveau)
    {
        try {
            return ApiResponse::success($sousNiveau, "Sous-Niveau Details");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to get details of a specific sous-niveau
    }
}
