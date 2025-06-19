<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Enseignant extends Model
{
     /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUlids,HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'id',
        'registration_number',
        'first_name',
        'last_name',
        'gender',
        'email',
        'phone',
        'email_verified_at',
        'password',
    ];
    public $incrementing = false;
    
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
    public function responsableNiveaux()
{
    return $this->hasMany(ResponsableNiveau::class, 'enseignant_id');
}

public function enseignantMatieres()
{
    return $this->hasMany(EnseignantMatiere::class, 'enseignant_id');
}

}
