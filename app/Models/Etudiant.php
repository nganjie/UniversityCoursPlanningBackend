<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Etudiant extends Model
{
    public $incrementing = false;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUlids,HasApiTokens, HasFactory, Notifiable,SoftDeletes;
    
    protected $fillable = [
        'id',
        'etablissement_id',
        'registration_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'email_verified_at',
        'password',
    ];

    /**
     * Relation avec l’établissement.
     */
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'etablissement_id');
    }
     /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function etudiantNiveaux()
{
    return $this->hasMany(EtudiantNiveau::class, 'etudiant_id');
}

}
