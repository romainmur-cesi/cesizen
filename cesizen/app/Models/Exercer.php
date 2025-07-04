<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercer extends Model
{
    /**
     * Le nom de la table associée au modèle.
     */
    protected $table = 'exercer';

    /**
     * Indique si le modèle doit être horodaté.
     */
    public $timestamps = false;

    /**
     * La clé primaire de la table (clé composite).
     */
    protected $primaryKey = ['id_utilisateur', 'id_exercice_respiration'];

    /**
     * Indique que la clé primaire n'est pas auto-incrémentée.
     */
    public $incrementing = false;

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'id_utilisateur',
        'id_exercice_respiration'
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'id_utilisateur' => 'integer',
        'id_exercice_respiration' => 'integer',
    ];

    /**
     * Relation avec l'utilisateur.
     * Chaque exercice appartient à un utilisateur.
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    /**
     * Relation avec l'exercice de respiration.
     * Chaque exercice appartient à un exercice de respiration.
     */
    public function exerciceRespiration()
    {
        return $this->belongsTo(ExerciceRespiration::class, 'id_exercice_respiration');
    }

    /**
     * Scope pour filtrer par utilisateur.
     */
    public function scopeParUtilisateur($query, $utilisateurId)
    {
        return $query->where('id_utilisateur', $utilisateurId);
    }

    /**
     * Scope pour filtrer par exercice de respiration.
     */
    public function scopeParExerciceRespiration($query, $exerciceId)
    {
        return $query->where('id_exercice_respiration', $exerciceId);
    }

    /**
     * Méthode pour créer un nouvel exercice.
     */
    public static function creerExercice($utilisateurId, $exerciceRespirationId)
    {
        return self::create([
            'id_utilisateur' => $utilisateurId,
            'id_exercice_respiration' => $exerciceRespirationId
        ]);
    }

    /**
     * Méthode pour vérifier si un utilisateur pratique un exercice de respiration.
     */
    public static function pratique($utilisateurId, $exerciceRespirationId)
    {
        return self::where('id_utilisateur', $utilisateurId)
                  ->where('id_exercice_respiration', $exerciceRespirationId)
                  ->exists();
    }

    /**
     * Méthode pour obtenir tous les exercices de respiration pratiqués par un utilisateur.
     */
    public static function exercicesParUtilisateur($utilisateurId)
    {
        return self::where('id_utilisateur', $utilisateurId)
                  ->with('exerciceRespiration')
                  ->get()
                  ->pluck('exerciceRespiration');
    }

    /**
     * Méthode pour obtenir tous les utilisateurs pratiquant un exercice de respiration.
     */
    public static function utilisateursPratiquantExercice($exerciceRespirationId)
    {
        return self::where('id_exercice_respiration', $exerciceRespirationId)
                  ->with('utilisateur')
                  ->get()
                  ->pluck('utilisateur');
    }

    /**
     * Méthode pour supprimer la relation exercice/utilisateur.
     */
    public static function arreterExercice($utilisateurId, $exerciceRespirationId)
    {
        return self::where('id_utilisateur', $utilisateurId)
                  ->where('id_exercice_respiration', $exerciceRespirationId)
                  ->delete();
    }

    /**
     * Méthode pour obtenir le nombre d'utilisateurs pratiquant un exercice.
     */
    public static function nombreUtilisateursPourExercice($exerciceRespirationId)
    {
        return self::where('id_exercice_respiration', $exerciceRespirationId)->count();
    }

    /**
     * Méthode pour obtenir le nombre d'exercices pratiqués par un utilisateur.
     */
    public static function nombreExercicesPourUtilisateur($utilisateurId)
    {
        return self::where('id_utilisateur', $utilisateurId)->count();
    }

    /**
     * Méthode pour obtenir les exercices les plus pratiqués.
     */
    public static function exercicesLesPlusPratiques($limite = 10)
    {
        return self::selectRaw('id_exercice_respiration, COUNT(*) as nombre_utilisateurs')
                  ->groupBy('id_exercice_respiration')
                  ->orderBy('nombre_utilisateurs', 'desc')
                  ->limit($limite)
                  ->with('exerciceRespiration')
                  ->get();
    }

    /**
     * Méthode pour obtenir les utilisateurs les plus actifs.
     */
    public static function utilisateursLesPlusActifs($limite = 10)
    {
        return self::selectRaw('id_utilisateur, COUNT(*) as nombre_exercices')
                  ->groupBy('id_utilisateur')
                  ->orderBy('nombre_exercices', 'desc')
                  ->limit($limite)
                  ->with('utilisateur')
                  ->get();
    }
}