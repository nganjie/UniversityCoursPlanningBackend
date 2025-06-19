<?php

namespace App\Models;

use App\Enums\EtudiantStatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class EtudiantNiveau extends Model
{
    use HasUlids;
    public $incrementing = false;
     protected $fillable = [
        'id',
        'etudiant_id',
        'niveau_id',
        'year',
        'status',
    ];

    protected $casts = [
        'year'       => 'datetime',
        'status'     => EtudiantStatusEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Relation vers l'étudiant concerné.
     */
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }

    /**
     * Relation vers le niveau concerné.
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'niveau_id');
    }
}
