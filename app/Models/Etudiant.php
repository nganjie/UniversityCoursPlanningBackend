<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *     schema="Etudiant",
 *     type="object",
 *     title="Etudiant",
 *     required={"id", "registration_number", "first_name", "last_name", "email", "password"},
 *     @OA\Property(property="id", type="string", format="uuid", example="uuid-example"),
 *     @OA\Property(property="registration_number", type="string", example="2025XYZ123"),
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *     @OA\Property(property="phone", type="string", example="+237123456789"),
 *     @OA\Property(property="gender", type="string", enum={"M", "F"}),
 *     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 * )
 */
class Etudiant extends Model
{
    public $incrementing = false;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids,HasApiTokens, HasFactory, Notifiable,SoftDeletes;
    
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
