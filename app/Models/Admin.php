<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids,HasApiTokens, HasFactory, Notifiable,HasRoles;
    public $incrementing = false;
    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "password",
        "phone",
        "gender",
        "role_id",
        "etablissement_id",
    ];
    protected $casts=[
        "first_name"=>"string",
        "last_name"=> "string",
        "email"=> "string",
        "password"=> "string",
        "phone"=> "string",
        "gender"=> "string"
    ];
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
    public function etablissement():BelongsTo{
        return $this->belongsTo(Etablissement::class);
    }
}
