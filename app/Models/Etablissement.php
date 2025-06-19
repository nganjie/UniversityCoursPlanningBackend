<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    use HasUlids;
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

}
