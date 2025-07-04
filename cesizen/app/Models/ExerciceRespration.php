<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciceRespiration extends Model
{
    /**
     * Le nom de la table associée au modèle.
     */
    protected $table = 'exercice_respirations';

    /**
     * La clé primaire de la table.
     */
    protected $primaryKey = 'id';

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'nom',
        'description',
        'duree',
        'temps_inspiration',
        'temps_apnee',
        'temps_expiration'
    ];

    /**
     * Les attributs qui doivent être cachés lors de la sérialisation.
     */
    protected $hidden = [];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'duree' => 'float',
        'temps_inspiration' => 'float',
        'temps_apnee' => 'float',
        'temps_expiration' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec les exercices pratiques.
     * Un exercice de respiration peut avoir plusieurs exercices pratiques.
     */
    public function exercicesPratiques()
    {
        return $this->hasMany(ExercicePratique::class, 'id_exercice_respiration');
    }

    /**
     * Relation avec les exercices (table de liaison).
     * Un exercice de respiration peut être pratiqué par plusieurs utilisateurs.
     */
    public function exercices()
    {
        return $this->hasMany(Exercer::class, 'id_exercice_respiration');
    }

    /**
     * Relation many-to-many avec les utilisateurs via la table exercer.
     * Un exercice de respiration peut être pratiqué par plusieurs utilisateurs.
     */
    public function utilisateurs()
    {
        return $this->belongsToMany(Utilisateur::class, 'exercer', 'id_exercice_respiration', 'id_utilisateur');
    }

    /**
     * Scope pour filtrer par durée minimale.
     */
    public function scopeDureeMinimale($query, $dureeMin)
    {
        return $query->where('duree', '>=', $dureeMin);
    }

    /**
     * Scope pour filtrer par durée maximale.
     */
    public function scopeDureeMaximale($query, $dureeMax)
    {
        return $query->where('duree', '<=', $dureeMax);
    }

    /**
     * Scope pour filtrer par durée entre deux valeurs.
     */
    public function scopeDureeEntre($query, $dureeMin, $dureeMax)
    {
        return $query->whereBetween('duree', [$dureeMin, $dureeMax]);
    }

    /**
     * Scope pour rechercher par nom.
     */
    public function scopeRechercherNom($query, $nom)
    {
        return $query->where('nom', 'like', '%' . $nom . '%');
    }

    /**
     * Scope pour rechercher dans nom et description.
     */
    public function scopeRechercher($query, $terme)
    {
        return $query->where(function($q) use ($terme) {
            $q->where('nom', 'like', '%' . $terme . '%')
              ->orWhere('description', 'like', '%' . $terme . '%');
        });
    }

    /**
     * Scope pour les exercices courts (moins de 5 minutes).
     */
    public function scopeCourts($query)
    {
        return $query->where('duree', '<', 5);
    }

    /**
     * Scope pour les exercices longs (plus de 15 minutes).
     */
    public function scopeLongs($query)
    {
        return $query->where('duree', '>', 15);
    }

    /**
     * Accesseur pour obtenir la durée totale d'un cycle.
     */
    public function getDureeCycleAttribute()
    {
        return $this->temps_inspiration + $this->temps_apnee + $this->temps_expiration;
    }

    /**
     * Accesseur pour obtenir le nombre de cycles dans l'exercice.
     */
    public function getNombreCyclesAttribute()
    {
        $dureeCycle = $this->duree_cycle;
        return $dureeCycle > 0 ? round(($this->duree * 60) / $dureeCycle) : 0;
    }

    /**
     * Accesseur pour obtenir la durée formatée.
     */
    public function getDureeFormateeAttribute()
    {
        $minutes = floor($this->duree);
        $secondes = ($this->duree - $minutes) * 60;
        
        if ($secondes > 0) {
            return $minutes . 'min ' . round($secondes) . 's';
        }
        
        return $minutes . 'min';
    }

    /**
     * Accesseur pour obtenir le pattern de respiration.
     */
    public function getPatternRespirationAttribute()
    {
        return $this->temps_inspiration . '-' . $this->temps_apnee . '-' . $this->temps_expiration;
    }

    /**
     * Méthode pour obtenir le nombre d'utilisateurs pratiquant cet exercice.
     */
    public function getNombreUtilisateurs()
    {
        return $this->utilisateurs()->count();
    }

    /**
     * Méthode pour obtenir le nombre total de pratiques.
     */
    public function getNombrePratiques()
    {
        return $this->exercicesPratiques()->count();
    }

    /**
     * Méthode pour obtenir la durée moyenne des pratiques.
     */
    public function getDureeMoyennePratiques()
    {
        return $this->exercicesPratiques()->avg('temps_pratique');
    }

    /**
     * Méthode pour vérifier si un utilisateur pratique cet exercice.
     */
    public function estPratiqueParUtilisateur($utilisateurId)
    {
        return $this->utilisateurs()->where('id_utilisateur', $utilisateurId)->exists();
    }

    /**
     * Méthode pour ajouter un utilisateur à cet exercice.
     */
    public function ajouterUtilisateur($utilisateurId)
    {
        if (!$this->estPratiqueParUtilisateur($utilisateurId)) {
            return Exercer::create([
                'id_exercice_respiration' => $this->id,
                'id_utilisateur' => $utilisateurId
            ]);
        }
        return false;
    }

    /**
     * Méthode statique pour obtenir les exercices les plus populaires.
     */
    public static function lesPlusPopulaires($limite = 10)
    {
        return self::withCount('utilisateurs')
                  ->orderBy('utilisateurs_count', 'desc')
                  ->limit($limite)
                  ->get();
    }

    /**
     * Méthode statique pour obtenir les exercices par durée.
     */
    public static function parDuree($ordre = 'asc')
    {
        return self::orderBy('duree', $ordre)->get();
    }

    /**
     * Méthode pour valider le pattern de respiration.
     */
    public function validerPattern()
    {
        return $this->temps_inspiration > 0 && 
               $this->temps_apnee >= 0 && 
               $this->temps_expiration > 0;
    }
}