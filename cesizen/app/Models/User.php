<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * Relation avec le modèle Utilisateur
     * Un User a un Utilisateur (profil détaillé)
     */
    public function utilisateur()
    {
        return $this->hasOne(Utilisateur::class, 'user_id');
    }

    /**
     * Créer automatiquement un utilisateur après la création d'un User
     */
    protected static function booted()
    {
        static::created(function ($user) {
            // Extraire nom et prénom du name si possible
            $nameParts = explode(' ', $user->name, 2);
            $prenom = $nameParts[0] ?? '';
            $nom = $nameParts[1] ?? '';

            Utilisateur::create([
                'user_id' => $user->id,
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $user->email,
                'mot_de_passe' => $user->password,
            ]);
        });
    }
}
