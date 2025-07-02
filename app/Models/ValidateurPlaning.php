<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidateurPlaning extends Model
{
    use HasFactory;
    use HasUuids;
    public $incrementing = false;
    protected $fillable = [
        'id',
        'admin_id',
        'niveau_id',
        'status',
    ];

    protected $casts = [
        'status'     => StatusEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation vers l'admin valideur.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Relation vers le niveau validé.
     */
    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'niveau_id');
    }
}
