<?php

namespace App\Models;

use App\Enums\DayEnum;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasUlids;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'salle_id',
        'planing_id',
        'matiere_id',
        'day',
        'start_date',
        'duration',
    ];

    protected $casts = [
        'day'        => DayEnum::class,
        'start_date' => 'datetime',
        'duration'   => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation vers la salle.
     */
    public function salle()
    {
        return $this->belongsTo(Salle::class, 'salle_id');
    }

    /**
     * Relation vers le planning.
     */
    public function planing()
    {
        return $this->belongsTo(Planing::class, 'planing_id');
    }

    /**
     * Relation vers la matière.
     */
    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'matiere_id');
    }
    

}
