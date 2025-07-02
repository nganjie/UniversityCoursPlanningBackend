<?php

namespace App\Models;

use App\Enums\BatimentEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Batiment extends Model
{
    use HasUuids;
     public $incrementing = false;
     protected $fillable = [
        'id',
        'name',
        'short_name',
        'adress',
        'status',
        'type',
    ];

    protected $casts = [
        'status' => 'boolean',
        'type' => BatimentEnum::class, // si tu utilises un enum PHP natif
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public function batimentEtablissements()
{
    return $this->hasMany(BatimentEtablissement::class, 'batiment_id');
}

public function salles()
{
    return $this->hasMany(Salle::class, 'batiment_id');
}

}
