<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class AvisEnseignant extends Model
{
    use HasUlids;
    public $incrementing = false;
     protected $fillable = [
        'id',
        'enseignant_matiere_id',
        'matiere_id',
        'title',
        'description',
        'is_valid',
    ];

    protected $casts = [
        'is_valid'   => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation vers l'association enseignant-matiere.
     */
    public function enseignantMatiere()
    {
        return $this->belongsTo(EnseignantMatiere::class, 'enseignant_matiere_id');
    }

    /**
     * Relation vers la matière.
     */
    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'matiere_id');
    }
    

}
