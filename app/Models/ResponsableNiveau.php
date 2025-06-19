<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class ResponsableNiveau extends Model
{
    use HasUlids;
    public $incrementing = false;
    
    protected $fillable = [
        'id',
        'enseignant_id',
        'niveau_id',
        'year',
        'status',
    ];

    protected $casts = [
        'year'       => 'datetime',
        'status'     => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation vers l'enseignant responsable.
     */
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'enseignant_id');
    }

    /**
     * Relation vers le niveau concerné.
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'niveau_id');
    }
    public function planings()
{
    return $this->hasMany(Planing::class, 'responsable_niveau_id');
}
}
