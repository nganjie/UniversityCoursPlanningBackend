<?php

use App\Enums\RoleEnum;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BatimentController;
use App\Http\Controllers\Admin\BatimentEtablissementController;
use App\Http\Controllers\Admin\EnseignantController;
use App\Http\Controllers\Admin\EtablissementController;
use App\Http\Controllers\Admin\FilliereController;
use App\Http\Controllers\Admin\NiveauController;
use App\Http\Controllers\Admin\SalleController;
use App\Http\Controllers\Admin\SousNiveauController;
use App\Http\Controllers\Authentificate\AuthAdminController;
use App\Http\Controllers\Authentificate\AuthEtudiantController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Etudiant\EtudiantController;
use App\Http\Controllers\Admin\EtudiantController as AdminEtudiantController;
use App\Http\Controllers\Admin\MatiereController;
use App\Http\Controllers\Authentificate\AuthEnseignantController;
use App\Models\BatimentEtablissement;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Filliere;
use App\Models\Matiere;
use App\Models\Niveau;
use App\Models\Permission;
use App\Models\Role;
use App\Models\SousNiveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * @OA\Info(
 *   version="1.0",
 *     
 *   title=" API Documentation",
 *   descrption="API documentation for version 1.0 endpoints.",
 *   
 *   @OA\Contact(
 *     email="test@mail.com"
 *   ),
 * )
 * @OA\Get(
 *   path="/",
 *   summary="Health-check endpoint"
 *   
 *   @OA\Response(response=200, description="OK")
 * )
 */
Route::get("test", function (Request $request) {
    return [
        "app"=>125
    ];
});
Route::get("permission_role",function(){
   // $uuid1 = Str::uuid()->toString();

    $permission=Permission::create([
        //'id' => Str::uuid()->toString(),
        "name"=>"all",
        "guard_name"=>"admins"
    ]);
    $permissionSemis=Permission::create([
       // 'id' => Str::uuid()->toString(),
        "name"=> "semis all",
        "guard_name"=>"admins"
    ]);
    $role1= Role::create([
        //'id' => Str::uuid()->toString(),
        "name"=> "Technical-Support",
        "guard_name"=>"admins"
    ]);
    $role1->givePermissionTo($permission);
    $role2= Role::create([
        //'id' => Str::uuid()->toString(),
        "name"=> "chef-etablissement",
        "guard_name"=>"admins"
    ]);
    $role2->givePermissionTo($permissionSemis);
    return [$role1,$role2];
});
Route::prefix("auth")->name("auth.")->group(function () {
    Route::prefix("admin/")->name("admin.")->group(function () {
          Route::post("create",[AuthAdminController::class,"register"]);
    Route::post("login",[AuthAdminController::class,"login"]);
    });
    Route::prefix("enseignants/")->name("enseignant.")->group(function () {
    Route::post("login",[AuthEnseignantController::class,"login"]);
    });
    Route::prefix("etudiants/")->name("etudiant.")->group(function () {
          Route::post("create",[AuthEtudiantController::class,"register"]);
    Route::post("login",[AuthEtudiantController::class,"login"]);
    });
  
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:enseignants');

Route::middleware('auth:admins')->name('admins.')->prefix('admins/')->group(function () {
   
    Route::controller(AdminController::class)->group(function () {
        Route::get('current','current');
        Route::put('update/{admin}','update');
        Route::post('add-role/{admin}','addRole');
         Route::middleware("role:".RoleEnum::TechnicalSupport->label())->group(function () {
        
        Route::get('all','all')->name('all');
    });
       
    });//.RoleEnum::TechnicalSupport->label().",".RoleEnum::ChefEtablissement->label()
    Route::middleware("role:".RoleEnum::TechnicalSupport->label())->group(function () {
        Route::controller(BatimentController::class)->name("batiments.")->prefix("batiments/")->group(function () {
            Route::post("create","register");
            Route::put("update/{batiment}","update");
            Route::get("all","all");
            Route::get("detail/{batiment}","detail");
        });
        Route::controller(BatimentEtablissementController::class)->name("batiments-etablissements.")->prefix("batiments-etablissements/")->group(function () {
            Route::post("create","register");
            Route::put("update/{batimentEtablissement}","update");
            Route::get("all","all");
            Route::get("detail/{batimentEtablissement}","detail");
        });
        Route::controller(SalleController::class)->name("salles.")->prefix("salles/")->group(function () {
            Route::post("create/{batiment}","register");
            Route::put("update/{salle}","update");
            Route::get("all","all");
            Route::get("all-batiment/{batiment}","allSallesBatiment");
            Route::get("detail/{salle}","detail");
        });
    });
    Route::middleware("role:Technical-Support|chef-etablissement")->name("etablissements.")->prefix("etablissements/")->controller(EtablissementController::class)->group(function () {
        
        Route::middleware("role:".RoleEnum::TechnicalSupport->label())->group(function () {
            Route::post("create","register");
            Route::post("add-admin/{etablissement}","addAdmin");
            Route::controller(FilliereController::class)->name("fillieres.")->prefix("fillieres/")->group(function () {
                Route::post("create/{etablissement}","register");
                Route::put("update/{filiere}","update");
                Route::get("all","all");
                Route::get("all/{etablissement}","allFillieresEtablissement");
                Route::get("detail/{filiere}","detail");
            });
            Route::controller(NiveauController::class)->name("niveaux.")->prefix("niveaux/")->group(function () {
                Route::post("create/{filliere}","register");
                Route::put("update/{niveau}","update");
                Route::get("all","all");
                Route::get("all-etablissement/{etablissement}","allNiveauxEtablissement");
                Route::get("all-filliere/{filliere}","allNiveauxFilliere");
                Route::get("detail/{niveau}","detail");
            });
            Route::controller(SousNiveauController::class)->name("sous-niveaux.")->prefix("sous-niveaux/")->group(function () {
                Route::post("create/{niveau}","register");
                Route::put("update/{sousNiveau}","update");
                Route::get("all","all");
                Route::get("all-niveau/{niveau}","allSousNiveauxNiveau");
                Route::get("detail/{sousNiveau}","detail");
            });
        });
        Route::get("all","all");
        Route::get("detail/{etablissement}","detail");
        
        Route::put("update/{etablissement}","update");
        
    });
    Route::controller(EnseignantController::class)->name("enseignants.")->prefix("enseignants/")->group(function () {
        Route::post("create/{etablissement}","register");
        Route::put("update/{enseignant}","update");
        Route::get("all","all");
        Route::put("add/{niveau}/responsable/{enseignant}","addResponsableNiveau");
        //Route::put("change/{niveau}/responsable/{enseignant}/to/{enseignant}","changeResponsableNiveau");
        Route::delete("remove-responsable/{responsableNiveau}","removeResponsableNiveau");
        Route::get("all/{etablissement}","allEnseignantsEtablissement");
        Route::get("detail/{enseignant}","detail");
    });
});
Route::middleware('auth:admins,enseignants')->name('enseignants.')->prefix('enseignants/')->group(function () {
    Route::controller(EnseignantController::class)->group(function () {
        Route::get('current','current');
        Route::post("create/{etablissement}","register");
        Route::put('update/{enseignant}','update');
        Route::get('all','all');
        Route::get('detail/{enseignant}','detail');
    });
    Route::controller(MatiereController::class)->name("matieres.")->prefix("matieres/")->group(function () {
        Route::post("create","register");
        Route::put("update/{matiere}","update");
        Route::get("all","all");
        Route::get("all-niveau/{niveau}","allMatieresNiveau");
        Route::get("all-sous-niveau/{sousNiveau}","allMatieresSousNiveau");
        Route::get("detail/{matiere}","detail");
    });
});
Route::middleware('auth:etudiants')->name('etudiants.')->prefix('etudiants/')->group(function () {
    Route::controller(EtudiantController::class)->group(function () {
        Route::get('current','current');
        Route::put('update/{etudiant}','update');
        Route::put("etudier/{niveau}","etudierNiveau");
        Route::delete("desabonner/{niveau}","desabonnerNiveau");
    });
});
Route::middleware('auth:admins,enseignants,etudiants')->name('public.')->prefix('public/')->group(function () {
    Route::controller(EnseignantController::class)->name("enseignants.")->prefix("enseignants/")->group(function () {
        Route::get("all","all");
        Route::get("detail/{enseignant}","detail");
    });
    Route::controller(FilliereController::class)->name("fillieres.")->prefix("fillieres/")->group(function () {
        Route::get("all","all");
        Route::get("detail/{filliere}","detail");
    });
    Route::controller(NiveauController::class)->name("niveaux.")->prefix("niveaux/")->group(function () {
        Route::get("all","all");
        Route::get("detail/{niveau}","detail");
    });
    Route::controller(SousNiveauController::class)->name("sous-niveaux.")->prefix("sous-niveaux/")->group(function () {
        Route::get("all","all");
        Route::get("detail/{sousNiveau}","detail");
    });
    Route::controller(BatimentController::class)->name("batiments.")->prefix("batiments/")->group(function () {
        Route::get("all","all");
        Route::get("detail/{batiment}","detail");
    });
    Route::controller(BatimentEtablissementController::class)->name("batiments-etablissements.")->prefix("batiments-etablissements/")->group(function () {
        Route::get("all","all");
        Route::get("detail/{batimentEtablissement}","detail");
    });
    Route::controller(SalleController::class)->name("salles.")->prefix("salles/")->group(function () {
        Route::get("all","all");
        Route::get("all-batiment/{batiment}","allSallesBatiment");
        Route::get("detail/{salle}","detail");
    });
    Route::controller(EtablissementController::class)->name("etablissements.")->prefix("etablissements/")->group(function () {
        Route::get("all","all");
        Route::get("detail/{etablissement}","detail");
    });

});