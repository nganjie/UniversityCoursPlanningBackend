<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    use HasUuids,HasFactory;
    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'filliere_id',
        'code',
        'name',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation vers la filière.
     */
    public function filliere()
    {
        return $this->belongsTo(Filliere::class, 'filliere_id');
    }

public function sousNiveaux()
{
    return $this->hasMany(SousNiveau::class, 'niveau_id');
}

public function matieres()
{
    return $this->hasMany(Matiere::class, 'niveau_id');
}

public function responsableNiveaux()
{
    return $this->hasMany(ResponsableNiveau::class, 'niveau_id');
}

public function etudiantNiveaux()
{
    return $this->hasMany(EtudiantNiveau::class, 'niveau_id');
}

public function validateurPlanings()
{
    return $this->hasMany(ValidateurPlaning::class, 'niveau_id');
}

}
