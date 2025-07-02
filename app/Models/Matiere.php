<?php

namespace App\Models;

use App\Enums\MatiereTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matiere extends Model
{
    use HasFactory;
    use HasUuids,SoftDeletes;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'niveau_id',
        'sous_niveau_id',
        'code',
        'name',
        'type',
    ];

    protected $casts = [
        'type'       => MatiereTypeEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relation vers le niveau principal.
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'niveau_id');
    }

    /**
     * Relation optionnelle vers le sous-niveau.
     */
    public function sousNiveau()
    {
        return $this->belongsTo(SousNiveau::class, 'sous_niveau_id');
    }
 

public function enseignantMatieres()
{
    return $this->hasMany(EnseignantMatiere::class, 'matiere_id');
}

public function cours()
{
    return $this->hasMany(Cours::class, 'matiere_id');
}

public function avisEnseignants()
{
    return $this->hasMany(AvisEnseignant::class, 'matiere_id');
}

}
