<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoriaClinica extends Model
{
    use HasFactory;

    protected $table = 'historias_clinicas';
    protected $primaryKey = 'id_hc';

    protected $fillable = [
        'id_paciente',
        'id_usuario',
        'fecha_consulta',
        'hora_consulta',
        'motivo_consulta',
        'diagnostico_principal',
        'descripcion_tratamiento',
        'observaciones',
    ];

    protected $casts = [
        'fecha_consulta' => 'date',
        'hora_consulta'  => 'datetime:H:i:s', // solo hora
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
    ];

    // ───────── Relaciones ─────────

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente', 'id_paciente');
    }


    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
