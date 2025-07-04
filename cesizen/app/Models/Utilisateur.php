<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;

    /**
     * Le nom de la table associée au modèle.
     */
    protected $table = 'utilisateurs';

    /**
     * La clé primaire de la table.
     */
    protected $primaryKey = 'id';

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'nom',
        'prenom', 
        'email',
        'mot_de_passe',
        'date_de_naissance',
        'preferences'
    ];

    /**
     * Les attributs qui doivent être cachés lors de la sérialisation.
     */
    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'date_de_naissance' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Obtenir le nom de la colonne mot de passe pour l'authentification.
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    /**
     * Obtenir l'identifiant pour l'authentification.
     */
    public function getAuthIdentifierName()
    {
        return 'email';
    }

    /**
     * Mutateur pour hasher automatiquement le mot de passe.
     */
    public function setMotDePasseAttribute($value)
    {
        $this->attributes['mot_de_passe'] = bcrypt($value);
    }

    /**
     * Relation avec le modèle User
     * Un Utilisateur appartient à un User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation avec les notifications.
     * Un utilisateur a plusieurs notifications.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_utilisateur');
    }

    /**
     * Relation avec les exercices de respiration.
     * Un utilisateur a plusieurs exercices de respiration.
     */
    public function exercicesRespiration()
    {
        return $this->hasMany(ExerciceRespiration::class, 'id_utilisateur');
    }

    /**
     * Relation avec les exercices pratiques.
     * Un utilisateur a plusieurs exercices pratiques.
     */
    public function exercicesPratiques()
    {
        return $this->hasMany(ExercicePratique::class, 'id_utilisateur');
    }

    /**
     * Relation avec les contenus.
     * Un utilisateur a plusieurs contenus.
     */
    public function contenus()
    {
        return $this->hasMany(Contenu::class, 'id_utilisateur');
    }

    /**
     * Relation avec les exercices via la table de liaison.
     * Un utilisateur peut avoir plusieurs exercices.
     */
    public function exercices()
    {
        return $this->belongsToMany(Exercer::class, 'exercer_utilisateur', 'id_utilisateur', 'id_exercer');
    }

    /**
     * Relation avec les consultations via la table de liaison.
     * Un utilisateur peut avoir plusieurs consultations.
     */
    public function consultations()
    {
        return $this->belongsToMany(Consulter::class, 'consulter_utilisateur', 'id_utilisateur', 'id_consulter');
    }

    /**
     * Relation avec les pratiques via la table de liaison.
     * Un utilisateur peut avoir plusieurs pratiques.
     */
    public function pratiques()
    {
        return $this->belongsToMany(Pratiquer::class, 'pratiquer_utilisateur', 'id_utilisateur', 'id_pratiquer');
    }

    /**
     * Accesseur pour obtenir le nom complet.
     */
    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * Scope pour filtrer les utilisateurs actifs.
     */
    public function scopeActifs($query)
    {
        return $query->whereNotNull('email');
    }

    /**
     * Scope pour rechercher par nom ou prénom.
     */
    public function scopeRechercherParNom($query, $nom)
    {
        return $query->where('nom', 'like', '%' . $nom . '%')
                    ->orWhere('prenom', 'like', '%' . $nom . '%');
    }
}