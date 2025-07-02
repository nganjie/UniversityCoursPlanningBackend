<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Batiment\RegisterSalleRequest;
use App\Http\Requests\Batiment\UpdateSalleRequest;
use App\Models\Batiment;
use App\Models\Salle;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class SalleController extends Controller
{
    public function register(RegisterSalleRequest $request, Batiment $batiment)
    {
        try {
            $validated = $request->validated();
            // Assuming you have a model for Salle and it can be created
            $salle = $batiment->salles()->create($validated);
            return ApiResponse::created($salle, "Salle registered successfully");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to register a new room
        // Validate and create a new room
    }

    public function update(UpdateSalleRequest $request,Salle $salle)
    {
        try{
            $validated = $request->validated();
            // Assuming you have a model for Salle and it can be updated
            $salle->update($validated);
            return ApiResponse::updated("Salle updated successfully", $salle);
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to update an existing room
        // Validate and update the room details
    }

    public function all(Request $request)
    {
        try{
            if($request->has('search')){
                $search = $request->input('search');
                // Assuming you have a searchable field in Salle model
                $salles = Salle::where('name', 'like', "%{$search}%")
                    ->orWhere('short_name', 'like', "%{$search}%")
                    ->paginate($request->input('per_page', 10));
                return ApiResponse::success($salles, "Search Results for Salles");
            } else {
                $salles = Salle::paginate($request->input('per_page', 10));
                // If no search term, return all salles
            }
            return ApiResponse::success($salles, "All Salles");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to retrieve all rooms or search for specific rooms
    }
    public function allSallesBatiment(Request $request,Batiment $batiment)
    {
        try{
            if($request->has('search')){
                $search = $request->input('search');
                // Assuming you have a searchable field in Salle model
                $salles = $batiment->salles()->where('name', 'like', "%{$search}%")
                    ->orWhere('short_name', 'like', "%{$search}%")
                    ->paginate($request->input('per_page', 10));
                return ApiResponse::success($salles, "Search Results for Salles in Batiment");
            } else {
                $salles = $batiment->salles()->paginate($request->input('per_page', 10));
                // If no search term, return all salles in the specified batiment
            }
            return ApiResponse::success($salles, "All Salles in Batiment");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to retrieve all rooms in a specific building
    }

    public function detail(Salle $salle)
    {
        try{
            return ApiResponse::success($salle, "Salle details retrieved successfully");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to retrieve details of a specific room
    }
}
