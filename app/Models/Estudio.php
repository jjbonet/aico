<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estudio extends Model
{
    use HasFactory;

    protected $table = 'estudios';
    protected $primaryKey = 'id_estudio';

    protected $fillable = [
        'id_paciente',
        'descripcion',
        'archivo_url',
        'tipo_archivo',
        'ts_subida',
    ];

    protected $casts = [
        'ts_subida'  => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ───────── Relaciones ─────────

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }
}
