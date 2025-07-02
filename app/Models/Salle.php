<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    use HasFactory;
    use HasUuids;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'batiment_id',
        'name',
        'short_name',
        'max_capacity',
        'status',
    ];

    protected $casts = [
        'max_capacity' => 'integer',
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec le bâtiment qui contient la salle.
     */
    public function batiment()
    {
        return $this->belongsTo(Batiment::class, 'batiment_id');
    }

public function cours()
{
    return $this->hasMany(Cours::class, 'salle_id');
}

}
