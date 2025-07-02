<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnseignantMatiere extends Model
{

    use HasFactory;
    use HasUuids;
    public $incrementing = false;
     protected $fillable = [
        'id',
        'matiere_id',
        'enseignant_id',
        'year',
        'status',
    ];

    protected $casts = [
        'year'       => 'datetime',
        'status'     => StatusEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation vers l’enseignant.
     */
    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'enseignant_id');
    }

    /**
     * Relation vers la matière.
     */
    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'matiere_id');
    }
}
