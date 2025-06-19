<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class SousNiveau extends Model
{
    use HasUlids;
    public $incrementing = false;
     protected $fillable = [
        'id',
        'niveau_id',
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
     * Relation vers le niveau parent.
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'niveau_id');
    }

public function matieres()
{
    return $this->hasMany(Matiere::class, 'sous_niveau_id');
}

}
