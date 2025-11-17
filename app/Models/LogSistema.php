<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogSistema extends Model
{
    use HasFactory;

    protected $table = 'logs';
    protected $primaryKey = 'id_log';

    public $timestamps = false; // solo tiene created_at

    protected $fillable = [
        'usuario_id',
        'nivel',
        'evento',
        'descripcion',
        'ip_origen',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // ───────── Relaciones ─────────

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
