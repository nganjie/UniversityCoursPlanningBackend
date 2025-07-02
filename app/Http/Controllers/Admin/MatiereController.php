<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MatiereTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Matiere\RegisterMatiereRequest;
use App\Http\Requests\Matiere\UpdateMatiereRequest;
use App\Models\Matiere;
use App\Models\Niveau;
use App\Models\SousNiveau;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    public function register(RegisterMatiereRequest $request){
        try {
            $validated = $request->validated();
            $user=$request->user();
            if((!empty($user->registration_number))&&!$user->responsableNiveaux()->where('niveau_id',$validated['niveau_id'])->exists()){
                return ApiResponse::error("You are not authorized to update this matiere");
            }
            if($validated['type'] == MatiereTypeEnum::GLOBAL->label()){
                $validated['sous_niveau_id'] = null; // Ensure sous_niveau_id is null for GLOBAL type
            } else {
                $sousNiveau = SousNiveau::find($validated['sous_niveau_id']);
                $validated['niveau_id'] = $sousNiveau->niveau_id; // Ensure niveau_id is null for SINGLE type
            }
            $matiere=Matiere::create($validated);

            return ApiResponse::created($matiere, "Matiere");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        } 
    }
    public function update(UpdateMatiereRequest $request, Matiere $matiere){
        try {
            //verify if current user is a admin or a enseignant responsable this niveau
            $user= $request->user();
            $validated = $request->validated();
            if((!empty($user->registration_number))&&!$user->responsableNiveaux()->where('niveau_id',$matiere->niveau_id)->exists()){
                return ApiResponse::error("You are not authorized to update this matiere");
            }
                //if user is responsable of this niveau
            
            if($validated['type'] == MatiereTypeEnum::GLOBAL->label()){
                $validated['sous_niveau_id'] = null; // Ensure sous_niveau_id is null for GLOBAL type
            } else {
                $sousNiveau = SousNiveau::find($validated['sous_niveau_id']);
                $validated['niveau_id'] = $sousNiveau->niveau_id; // Ensure niveau_id is null for SINGLE type
            }
            $matiere->update($validated);
            return ApiResponse::updated("Matiere", $matiere);
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function all(Request $request){
        try {
            if($request->has('search')){
                $search = $request->input('search');
                $matieres = Matiere::where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->paginate($request->input('per_page', 10));
                return ApiResponse::success($matieres, "Search Results for Matieres");
            }
            $matieres = Matiere::paginate($request->input('per_page', 10));
            return ApiResponse::success($matieres, "All Matieres");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function allMatieresNiveau(Request $request, Niveau $niveau){
        try {
            if($request->has('search')){
                $search = $request->input('search');
                $matieres = $niveau->matieres()->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->paginate($request->input('per_page', 10));
                return ApiResponse::success($matieres, "Search Results for Matieres in Niveau");
            }
            $matieres = $niveau->matieres()->paginate($request->input('per_page', 10));
            return ApiResponse::success($matieres, "All Matieres in Niveau");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function allMatieresSousNiveau(Request $request, SousNiveau $sousNiveau){
        try {
            if($request->has('search')){
                $search = $request->input('search');
                $matieres = $sousNiveau->matieres()->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->paginate($request->input('per_page', 10));
                return ApiResponse::success($matieres, "Search Results for Matieres in Sous Niveau");
            }
            $matieres = $sousNiveau->matieres()->paginate($request->input('per_page', 10));
            return ApiResponse::success($matieres, "All Matieres in Sous Niveau");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function detail(Matiere $matiere){
        try {
            return ApiResponse::success($matiere, "Matiere Details");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
}
