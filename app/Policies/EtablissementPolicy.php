<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Admin;
use App\Models\Etablissement;
use Illuminate\Auth\Access\Response;

class EtablissementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $admin, Etablissement $etablissement): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->hasRole(RoleEnum::TechnicalSupport->label());
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $admin, Etablissement $etablissement): bool
    {
        //dd($admin->hasRole(RoleEnum::TechnicalSupport->label()));
        return $admin->etablissement_id===$etablissement->id||$admin->hasRole(RoleEnum::TechnicalSupport->label());
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $admin, Etablissement $etablissement): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $admin, Etablissement $etablissement): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $admin, Etablissement $etablissement): bool
    {
        return false;
    }
}
