<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EtudiantStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Admin\RegisterEnseignantRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Http\Requests\Admin\UpdateEnseignantRequest;
use App\Models\Enseignant;
use App\Models\Etablissement;
use App\Models\Niveau;
use App\Models\ResponsableNiveau;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class EnseignantController extends Controller
{
    //
    public function register(RegisterEnseignantRequest $request,Etablissement $etablissement){
        try{
            $validated= $request->validated();
            //dd($validated);
           // $validated['etablissement_id']=$etablissement->id;
            $data=$etablissement->enseignants()->create($validated);
            return ApiResponse::created($data,"Enseignant");
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function update(UpdateEnseignantRequest $request,Enseignant $enseignant){
        try{
            $validated= $request->validated();
            //dd($validated);
           $enseignant->update($validated);
            return ApiResponse::success($enseignant,"Enseignant");
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function allEnseignantsEtablissement(Etablissement $etablissement){
        try{
            if(request()->has('search')){
                $search = request()->input('search');
                $data = $etablissement->enseignants()
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->paginate(request()->get('per_page', 10));
                return ApiResponse::success($data, "Search Results for Enseignants");
            }else{
                // If no search term, return all enseignants
                $data = $etablissement->enseignants()->paginate(request()->get('per_page', 10));
            }
            return ApiResponse::success($data,"Enseignants");
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function all(Request $request){
        try{
            if($request->has('search')){
                $search = $request->input('search');
                // Assuming you have a searchable field in Enseignant model
                $data = Enseignant::where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->paginate($request->get('per_page', 10));
                return ApiResponse::success($data, "Search Results for Enseignants");
            }else{
                 $data=Enseignant::paginate($request->get('per_page', 10));
                // If no search term, return all enseignants
            }
           
            return ApiResponse::success($data,"Enseignants");
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function detail(Request $request,Enseignant $enseignant){
        try{
            return ApiResponse::success($enseignant,"Enseignants");
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function addResponsableNiveau(Request $request,Niveau $niveau, Enseignant $enseignant)
    {
        try {
            $responsableNiveau=ResponsableNiveau::create([
                'enseignant_id' => $enseignant->id,
                'niveau_id' => $niveau->id,
                "year" => now(),// Assuming 'status' is a boolean field indicating if the teacher is responsible for the level
            ]);
            return ApiResponse::success($enseignant->load('responsableNiveaux'), "Enseignant is now responsible for the niveau");
        } catch (\Exception $e) {
            throw new HttpResponseException(ApiResponse::error($e->getMessage(), $e));
        }
    }
    public function changeResponsableNiveau(Request $request, Niveau $niveau, Enseignant $enseignant, Enseignant $newEnseignant)
    {
        try {
            $responsableNiveau = ResponsableNiveau::where('enseignant_id', $enseignant->id)
                ->where('niveau_id', $niveau->id)
                ->first();

            if (!$responsableNiveau) {
                return ApiResponse::error("Enseignant is not responsible for this niveau");
            }
            //create a new ResponsableNiveau for the new enseignant
            $newResponsableNiveau = ResponsableNiveau::create([
                'enseignant_id' => $newEnseignant->id,
                'niveau_id' => $niveau->id,
                'year' => now(), // Assuming 'status' is a boolean field indicating if the teacher is responsible for the level
            ]);
            //change the status of the old responsable niveau to false
            $responsableNiveau->status = false; // Assuming 'status' is a boolean field indicating if the teacher is responsible for the level
            $responsableNiveau->save();

            // Update the enseignant_id to the new enseignant
            //$responsableNiveau->enseignant_id = $newEnseignant->id;
            //$responsableNiveau->save();

            return ApiResponse::success($newEnseignant->load('responsableNiveaux'), "Responsable niveau changed successfully");
        } catch (\Exception $e) {
            throw new HttpResponseException(ApiResponse::error($e->getMessage(), $e));
        }
    }
    public function removeResponsableNiveau(Request $request, ResponsableNiveau $responsableNiveau)
    {
        try {
            $responsableNiveau->delete();
            return ApiResponse::success(null, "Responsable niveau removed successfully");
        } catch (\Exception $e) {
            throw new HttpResponseException(ApiResponse::error($e->getMessage(), $e));
        }
    }
}
