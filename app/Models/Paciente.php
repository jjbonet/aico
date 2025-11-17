<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes';
    protected $primaryKey = 'id_paciente';

    protected $fillable = [
        'dni',
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'telefono',
        'email',
        'obra_social',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
    ];

    // ───────── Relaciones ─────────

    public function historiasClinicas()
    {
        return $this->hasMany(HistoriaClinica::class, 'id_paciente', 'id_paciente');
    }


    public function turnos()
    {
        return $this->hasMany(Turno::class, 'id_paciente');
    }

    public function estudios()
    {
        return $this->hasMany(Estudio::class, 'id_paciente');
    }
}
