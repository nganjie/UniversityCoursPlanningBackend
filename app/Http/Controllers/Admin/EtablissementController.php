<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\Admin\RegisterAdminRequest;
use App\Http\Requests\Admin\RegisterEtablissementRequest;
use App\Http\Requests\Admin\UpdateEtablissementRequest;
use App\Models\Admin;
use App\Models\Etablissement;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class EtablissementController extends Controller
{
    public function register(RegisterEtablissementRequest $request){
        try{
            $validated= $request->validated();
             if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            //return $file;
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/logos', $filename);
            $validated['logo_url']='storage/logos/' . $filename;
        }
            $data=Etablissement::create($validated);
            
            return ApiResponse::success($data);
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
     public function update(UpdateEtablissementRequest $request,Etablissement $etablissement){
        try{
           // return $request;
           //$admin=Admin::find($request->user()->id);
            Gate::authorize("update", $etablissement);
            $validated= $request->validated();
           // return $validated;
             if ($request->hasFile('logo')) {
            // Supprimer l'ancien logo s'il existe
            if ($etablissement->logo_url && Storage::exists(str_replace('storage/', 'public/', $etablissement->logo_url))) {
                Storage::delete(str_replace('storage/', 'public/', $etablissement->logo_url));
            }

            $file = $request->file('logo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/logos', $filename);
            $validated['logo_url']= 'storage/logos/' . $filename;
        }
            $etablissement->update($validated);
            
            return ApiResponse::success($etablissement);
        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function addAdmin(RegisterAdminRequest $request,Etablissement $etablissement){
        try{
            $role=Role::where('name',RoleEnum::ChefEtablissement->label())->first();
           // return $role;
            $validated= $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            $admin =Admin::create($validated);
            
            //return $role;
            $admin->etablissement()->associate($etablissement);
            $admin->assignRole($role->id);
            $admin->save();
            return ApiResponse::created($admin->with(['roles','etablissement'])->first(),'Admin');

        }catch(\Exception $e){
            throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function all(Request $request){
        try{
            if($request->has('search')){
                $search = $request->input('search');
                // Assuming you have a searchable field in Etablissement model
                $etablissements = Etablissement::where('name', 'like', "%{$search}%")
                    ->orWhere('short_name', 'like', "%{$search}%")
                    ->with(['admins'])
                    ->paginate($request->input('per_page', 4));
                return ApiResponse::success($etablissements, "Search Results for Etablissements");
            }else{
                $etablissements=Etablissement::with(['admins'])->paginate($request->input('per_page',4));
                // If no search term, return all etablissements
            }
            
            return ApiResponse::success($etablissements);
        }catch(\Exception $e){
             throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
    public function detail(Request $request,Etablissement $etablissement){
        try{
            return ApiResponse::success($etablissement->with('admins')->first());
        }catch(\Exception $e){
             throw new HttpResponseException(ApiResponse::error($e->getMessage(),$e));
        }
    }
}
