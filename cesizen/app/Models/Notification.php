<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'type',
        'message',
        'date',
        'created_at',
        'id_utilisateur'
    ];

    protected $casts = [
        'date' => 'datetime',
        'created_at' => 'timestamp',
    ];

    /**
     * Relation avec le modèle Utilisateur
     * Une notification appartient à un utilisateur
     */
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }
}