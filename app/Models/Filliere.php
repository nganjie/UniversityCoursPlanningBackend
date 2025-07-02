<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filliere extends Model
{
    use HasUuids,HasFactory, SoftDeletes;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'etablissement_id',
        'code',
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relation vers l’établissement.
     */
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'etablissement_id');
    }
    public function niveaux()
{
    return $this->hasMany(Niveau::class, 'filliere_id');
}

}
