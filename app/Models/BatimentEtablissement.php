<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatimentEtablissement extends Model
{
    use HasUuids,HasFactory;
    public $incrementing = false;


    protected $table = 'batiment_etablissements';

    protected $fillable = [
        'id',
        'batiment_id',
        'etablissement_id',
        'name',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation vers le bâtiment.
     */
    public function batiment()
    {
        return $this->belongsTo(Batiment::class, 'batiment_id');
    }

    /**
     * Relation vers l'établissement.
     */
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'etablissement_id');
    }
}
