<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Batiment\RegisterBatimentRequest;
use App\Http\Requests\Batiment\UpdateBatimentRequest;
use App\Models\Batiment;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class BatimentController extends Controller
{
    public function register(RegisterBatimentRequest $request)
    {
        try {
            $validated = $request->validated();
            // Assuming you have a model for Batiment and it can be created
            $batiment = Batiment::create($validated);
            return ApiResponse::created($batiment, "Batiment");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to register a new building
        // Validate and create a new building
    }

    public function update(UpdateBatimentRequest $request,Batiment $batiment)
    {
        try {
            $validated = $request->validated();
            // Assuming you have a model for Batiment and it can be updated
            $batiment->update($validated);
            return ApiResponse::updated("Batiment", $batiment);
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to update an existing building
        // Validate and update the building details
    }

    public function all(Request $request)
    {
        try {
            if($request->has('search')){
                $search = $request->input('search');
                // Assuming you have a searchable field in Batiment model
                $batiments = Batiment::where('name', 'like', "%{$search}%")
                    ->orWhere('short_name', 'like', "%{$search}%")
                    ->paginate($request->input('per_page', 10));
                return ApiResponse::success($batiments, "Search Results for Batiments");
            } else {
                $batiments = Batiment::paginate($request->input('per_page', 10));
                // If no search term, return all batiments
            }
            
            return ApiResponse::success($batiments, "All Batiments");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to get all buildings
        // Return paginated list of buildings
    }

    public function detail(Batiment $batiment)
    {
        try {
            // Assuming you have a model for Batiment and it can be retrieved
            return ApiResponse::success($batiment, "Batiment Details");
        } catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
        // Logic to get details of a specific building
        // Return the building details
    }
}
