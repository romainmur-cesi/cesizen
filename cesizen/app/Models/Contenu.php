<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenu extends Model
{
    /**
     * Le nom de la table associée au modèle.
     */
    protected $table = 'contenus';

    /**
     * La clé primaire de la table.
     */
    protected $primaryKey = 'id';

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'titre',
        'description',
        'categorie'
    ];

    /**
     * Les attributs qui doivent être cachés lors de la sérialisation.
     */
    protected $hidden = [];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec les consultations.
     * Un contenu peut être consulté par plusieurs utilisateurs.
     */
    public function consultations()
    {
        return $this->hasMany(Consulter::class, 'id_contenu');
    }

    /**
     * Relation many-to-many avec les utilisateurs via la table consulter.
     * Un contenu peut être consulté par plusieurs utilisateurs.
     */
    public function utilisateurs()
    {
        return $this->belongsToMany(Utilisateur::class, 'consulter', 'id_contenu', 'id_utilisateur');
    }

    /**
     * Scope pour filtrer par catégorie.
     */
    public function scopeParCategorie($query, $categorie)
    {
        return $query->where('categorie', $categorie);
    }

    /**
     * Scope pour rechercher dans le titre.
     */
    public function scopeRechercherTitre($query, $titre)
    {
        return $query->where('titre', 'like', '%' . $titre . '%');
    }

    /**
     * Scope pour rechercher dans la description.
     */
    public function scopeRechercherDescription($query, $description)
    {
        return $query->where('description', 'like', '%' . $description . '%');
    }

    /**
     * Scope pour rechercher dans titre ET description.
     */
    public function scopeRechercher($query, $terme)
    {
        return $query->where(function($q) use ($terme) {
            $q->where('titre', 'like', '%' . $terme . '%')
              ->orWhere('description', 'like', '%' . $terme . '%');
        });
    }

    /**
     * Scope pour obtenir les contenus récents.
     */
    public function scopeRecents($query, $jours = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($jours));
    }

    /**
     * Accesseur pour obtenir le titre formaté.
     */
    public function getTitreFormateAttribute()
    {
        return ucfirst($this->titre);
    }

    /**
     * Accesseur pour obtenir la description tronquée.
     */
    public function getDescriptionCourteAttribute()
    {
        return strlen($this->description) > 50 
            ? substr($this->description, 0, 50) . '...' 
            : $this->description;
    }

    /**
     * Méthode pour obtenir le nombre de consultations.
     */
    public function getNombreConsultations()
    {
        return $this->consultations()->count();
    }

    /**
     * Méthode pour vérifier si un utilisateur a consulté ce contenu.
     */
    public function estConsulteParUtilisateur($utilisateurId)
    {
        return $this->utilisateurs()->where('id_utilisateur', $utilisateurId)->exists();
    }

    /**
     * Méthode pour marquer ce contenu comme consulté par un utilisateur.
     */
    public function marquerCommeConsulte($utilisateurId)
    {
        if (!$this->estConsulteParUtilisateur($utilisateurId)) {
            return Consulter::create([
                'id_contenu' => $this->id,
                'id_utilisateur' => $utilisateurId
            ]);
        }
        return false;
    }

    /**
     * Méthode statique pour obtenir les contenus par catégorie.
     */
    public static function parCategorie($categorie)
    {
        return self::where('categorie', $categorie)->get();
    }

    /**
     * Méthode statique pour obtenir toutes les catégories disponibles.
     */
    public static function getCategories()
    {
        return self::distinct()->pluck('categorie')->filter();
    }

    /**
     * Méthode statique pour obtenir les contenus les plus consultés.
     */
    public static function lesPlusConsultes($limite = 10)
    {
        return self::withCount('consultations')
                  ->orderBy('consultations_count', 'desc')
                  ->limit($limite)
                  ->get();
    }
}