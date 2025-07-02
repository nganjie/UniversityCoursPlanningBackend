<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planing extends Model
{
    use HasFactory;
    use HasUuids;
    public $incrementing = false;
      protected $fillable = [
        'id',
        'admin_id',
        'responsable_niveau_id',
        'start_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation vers l'admin (peut être null).
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * Relation vers le responsable niveau (obligatoire).
     */
    public function responsableNiveau()
    {
        return $this->belongsTo(ResponsableNiveau::class, 'responsable_niveau_id');
    }


public function cours()
{
    return $this->hasMany(Cours::class, 'planing_id');
}

}
