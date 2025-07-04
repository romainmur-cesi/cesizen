<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulter extends Model
{
    /**
     * Le nom de la table associée au modèle.
     */
    protected $table = 'consulter';

    /**
     * Indique si le modèle doit être horodaté.
     */
    public $timestamps = false;

    /**
     * La clé primaire de la table (si c'est une table de liaison).
     * Pour une table de liaison, on peut définir les clés composées.
     */
    protected $primaryKey = ['id_utilisateur', 'id_contenu'];

    /**
     * Indique que la clé primaire n'est pas auto-incrémentée.
     */
    public $incrementing = false;

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'id_utilisateur',
        'id_contenu'
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'id_utilisateur' => 'integer',
        'id_contenu' => 'integer',
    ];

    /**
     * Relation avec l'utilisateur.
     * Chaque consultation appartient à un utilisateur.
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    /**
     * Relation avec le contenu.
     * Chaque consultation appartient à un contenu.
     */
    public function contenu()
    {
        return $this->belongsTo(Contenu::class, 'id_contenu');
    }

    /**
     * Scope pour filtrer par utilisateur.
     */
    public function scopeParUtilisateur($query, $utilisateurId)
    {
        return $query->where('id_utilisateur', $utilisateurId);
    }

    /**
     * Scope pour filtrer par contenu.
     */
    public function scopeParContenu($query, $contenuId)
    {
        return $query->where('id_contenu', $contenuId);
    }

    /**
     * Méthode pour créer une nouvelle consultation.
     */
    public static function creerConsultation($utilisateurId, $contenuId)
    {
        return self::create([
            'id_utilisateur' => $utilisateurId,
            'id_contenu' => $contenuId
        ]);
    }

    /**
     * Méthode pour vérifier si un utilisateur a consulté un contenu.
     */
    public static function aConsulte($utilisateurId, $contenuId)
    {
        return self::where('id_utilisateur', $utilisateurId)
                  ->where('id_contenu', $contenuId)
                  ->exists();
    }

    /**
     * Méthode pour obtenir tous les contenus consultés par un utilisateur.
     */
    public static function contenusConsultesParUtilisateur($utilisateurId)
    {
        return self::where('id_utilisateur', $utilisateurId)
                  ->with('contenu')
                  ->get()
                  ->pluck('contenu');
    }

    /**
     * Méthode pour obtenir tous les utilisateurs qui ont consulté un contenu.
     */
    public static function utilisateursAyantConsulteContenu($contenuId)
    {
        return self::where('id_contenu', $contenuId)
                  ->with('utilisateurs')
                  ->get()
                  ->pluck('utilisateurs');
    }
}