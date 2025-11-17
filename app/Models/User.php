<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'dni',
        'name',
        'apellido',
        'telefono',
        'rol',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ───────── Relaciones ─────────

    public function historiasClinicas()
    {
        return $this->hasMany(HistoriaClinica::class, 'id_usuario');
    }

    public function turnos()
    {
        return $this->hasMany(Turno::class, 'id_usuario');
    }

    public function logsSistema()
    {
        return $this->hasMany(LogSistema::class, 'usuario_id');
    }
}
