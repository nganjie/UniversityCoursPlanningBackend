<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etablissement extends Model
{
    use HasFactory;
    use HasUuids;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'name',
        'short_name',
        'logo_url',
        'description',
    ];
    public function batimentEtablissements()
{
    return $this->hasMany(BatimentEtablissement::class, 'etablissement_id');
}

public function fillieres()
{
    return $this->hasMany(Filliere::class, 'etablissement_id');
}

public function etudiants()
{
    return $this->hasMany(Etudiant::class, 'etablissement_id');
}
public function admins():HasMany{
    return $this->hasMany(Admin::class);
}
public function enseignants():HasMany{
    return $this->hasMany(Enseignant::class);
}

}
