<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Batiment\RegisterBatimentEtablissementRequest;
use App\Models\BatimentEtablissement;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class BatimentEtablissementController extends Controller
{
    public function register(RegisterBatimentEtablissementRequest $request)
    {
        try {
            $validated = $request->validated();
            // Logic to register a new building for an establishment
            // Validate and create a new building for the specified establishment
            $batimentEtablissement = BatimentEtablissement::create($validated);
            return ApiResponse::created($batimentEtablissement, "Building registered successfully");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to register a new building for an establishment
        // Validate and create a new building for the specified establishment
    }
    public function update(RegisterBatimentEtablissementRequest $request, BatimentEtablissement $batimentEtablissement)
    {
        try {
            $validated = $request->validated();
            // Logic to update an existing building for an establishment
            // Validate and update the building details for the specified establishment
            $batimentEtablissement->update($validated);
            return ApiResponse::updated("Building updated successfully", $batimentEtablissement);
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to update an existing building for an establishment
        // Validate and update the building details for the specified establishment
    }
    public function all(Request $request)
    {
        try {
            if($request->has('search')){
                $search = $request->input('search');
                // Assuming you have a searchable field in BatimentEtablissement model
                $batimentsEtablissements = BatimentEtablissement::where('name', 'like', "%{$search}%")
                    ->paginate($request->input('per_page', 10));
                return ApiResponse::success($batimentsEtablissements, "Search Results for Buildings");
            } else {
                $batimentsEtablissements = BatimentEtablissement::paginate($request->input('per_page', 10));
                // If no search term, return all buildings
            }
            return ApiResponse::success($batimentsEtablissements, "All Buildings");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to retrieve all buildings for an establishment
        // Return a paginated list of buildings for the specified establishment
    }
    public function detail(BatimentEtablissement $batimentEtablissement)
    {
        try {
            return ApiResponse::success($batimentEtablissement, "Building details retrieved successfully");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to retrieve details of a specific building for an establishment
        // Return the details of the specified building

    }
}
