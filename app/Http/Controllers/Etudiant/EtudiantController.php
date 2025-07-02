<?php

namespace App\Http\Controllers\Etudiant;

use App\Enums\EtudiantStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Etudiant\UpdateEtudiantRequest;
use App\Models\Etudiant;
use App\Models\EtudiantNiveau;
use App\Models\Niveau;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function current(){
        try{
            $etudiant = auth()->user();
            return ApiResponse::success($etudiant, "Current Etudiant");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function update(UpdateEtudiantRequest $request,Etudiant $etudiant){
        try{
            $validated = $request->validated();
            $etudiant->update($validated);
            return ApiResponse::success($etudiant, "Etudiant Updated Successfully");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function etudierNiveau(Request $request,Niveau $niveau){
        try{
            $etudiant = auth()->user();
            $isValidNiveau = $etudiant->etudiantNiveaux()->where('status', EtudiantStatusEnum::Active->label())->exists();
            if($isValidNiveau){
                return ApiResponse::error("Etudiant is already studying a classroom", 400);
            }
            $etudiantNiveau=EtudiantNiveau::create([
                'etudiant_id' => $etudiant->id,
                'niveau_id' => $niveau->id,
                'year' => now(),
                'status' =>EtudiantStatusEnum::Active->label() // Assuming 'active' is a valid status in your
            ]);


            return ApiResponse::success($etudiant->load('etudiantNiveaux')->first(), "Etudiant is now studying the niveau");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function desabonnerNiveau(Niveau $niveau){
        try{
            $etudiant = auth()->user();
            $etudiantNiveau = $etudiant->etudiantNiveaux()->where('niveau_id', $niveau->id)
                ->where('status', EtudiantStatusEnum::Active->label())
                ->whereNull('deleted_at') // Ensure the record is not soft deleted
                ->first();

            if (!$etudiantNiveau) {
                return ApiResponse::error("Etudiant is not subscribed to this classroom");
            }

            $etudiantNiveau->delete();
            return ApiResponse::success(null, "Etudiant has been unsubscribed from the niveau");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
}
