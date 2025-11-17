<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Turno extends Model
{
    use HasFactory;

    protected $table = 'turnos';
    protected $primaryKey = 'id_turno';

    protected $fillable = [
        'id_paciente',
        'id_usuario',      // puede ser null
        'fecha_turno',
        'hora_turno',
        'motivo',
        'estado',
    ];

    protected $casts = [
        'fecha_turno' => 'date',
        'hora_turno'  => 'datetime:H:i:s',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    // ───────── Relaciones ─────────

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }

    public function usuario()
    {
        // Puede ser null (turno sin profesional asignado todavía)
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
