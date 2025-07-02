<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Niveau\RegisterNiveauRequest;
use App\Http\Requests\Niveau\UpdateNiveauRequest;
use App\Models\Etablissement;
use App\Models\Filliere;
use App\Models\Niveau;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class NiveauController extends Controller
{
    public function register(RegisterNiveauRequest $request,Filliere $filliere)
    {
        try {
            $validated = $request->validated();
            //return $validated;
            // Assuming you have a model for Filliere and it has a relation with Niveau
             // Ensure the filliere_id is set
            $niveau = $filliere->niveaux()->create($validated);
            return ApiResponse::created($niveau, "Niveau");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to register a new niveau
        // Validate and create a new niveau for the given etablissement
    }

    public function update(UpdateNiveauRequest $request,Niveau $niveau)
    {
        try {
            $validated = $request->validated();
            // Assuming you have a model for Niveau and it can be updated
            $niveau->update($validated);
            return ApiResponse::updated( "Niveau",$niveau);
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to update an existing niveau
        // Validate and update the niveau details
    }

    public function all(Request $request)
    {
        try {
            if($request->has('search')){
                $search = $request->input('search');
                // Assuming you have a searchable field in Niveau model
                $niveaux = Niveau::where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->paginate($request->input('per_page', 10));
                return ApiResponse::success($niveaux, "Search Results for Niveaux");
            }
            $niveaux = Niveau::paginate($request->input('per_page', 10));
            return ApiResponse::success($niveaux, "All Niveaux");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to get all niveaux
        // Return paginated list of niveaux
    }

    public function allNiveauxEtablissement(Etablissement $etablissement)
    {
        try {
            if(request()->has('search')){
                $search = request()->input('search');
                $niveaux = $etablissement->fillieres()
                    ->whereHas('niveaux', function($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                              ->orWhere('code', 'like', "%{$search}%");
                    })
                    ->paginate(request()->get('per_page', 10));
                return ApiResponse::success($niveaux, "Search Results for Niveaux in Etablissement");
            }
            $niveaux = $etablissement->fillieres()->with('niveaux')->paginate(request()->get('per_page', 10));
            return ApiResponse::success($niveaux, "All Niveaux for Etablissement");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to get all niveaux for a specific etablissement
        // Return paginated list of niveaux for the etablissement
    }
    public function allNiveauxFilliere(Request $request,Filliere $filliere)
    {
        try {
            if(request()->has("search")){
                $search = request()->input("search");
                $niveaux = $filliere->niveaux()
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->paginate($request->input('per_page', 10));
                    return ApiResponse::success($niveaux,'Search Results for Niveaux in Filliere');
            }
            $niveaux = $filliere->niveaux()->paginate($request->input('per_page', 10));
            return ApiResponse::success($niveaux, "All Niveaux for filliere");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }

        // Logic to get all niveaux for a specific filliere
        // Return paginated list of niveaux for the filliere
    }

    public function detail(Niveau $niveau)
    {
        try {
            return ApiResponse::success($niveau, "Niveau details");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to get details of a specific niveau
        // Return the niveau details
    }
}
