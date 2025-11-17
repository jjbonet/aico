<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Paciente;

class AicoTestPaciente extends Command
{
    /**
     * Nombre y firma del comando.
     *
     * Uso:
     *   php artisan aico:test-paciente 303333444
     */
    protected $signature = 'aico:test-paciente {dni : DNI del paciente}';

    /**
     * Descripción del comando.
     */
    protected $description = 'Muestra un resumen clínico de un paciente (datos, historias, turnos y estudios) dado su DNI';

    /**
     * Ejecuta el comando.
     */
    public function handle(): int
    {
        $dni = $this->argument('dni');

        $this->info("Buscando paciente con DNI {$dni}...\n");

        // Cargamos el paciente con todas las relaciones relevantes
        $paciente = Paciente::with([
            'historiasClinicas' => function ($q) {
                $q->orderByDesc('fecha_consulta')->orderByDesc('created_at');
            },
            'turnos' => function ($q) {
                $q->orderByDesc('fecha_turno')->orderByDesc('hora_turno');
            },
            'estudios' => function ($q) {
                $q->orderByDesc('ts_subida');
            },
        ])->where('dni', $dni)->first();

        if (!$paciente) {
            $this->error("No se encontró ningún paciente con DNI {$dni}.");
            return self::FAILURE;
        }

        // ───────── DATOS BÁSICOS DEL PACIENTE ─────────
        $this->line('========================================');
        $this->info('📌 DATOS DEL PACIENTE');
        $this->line('========================================');

        $this->line('ID           : ' . $paciente->id_paciente);
        $this->line('Nombre       : ' . $paciente->nombre . ' ' . $paciente->apellido);
        $this->line('DNI          : ' . $paciente->dni);
        $this->line('Fecha Nac.   : ' . ($paciente->fecha_nacimiento?->format('d/m/Y') ?? '-'));
        $this->line('Teléfono     : ' . ($paciente->telefono ?? '-'));
        $this->line('Email        : ' . ($paciente->email ?? '-'));
        $this->line('Obra social  : ' . ($paciente->obra_social ?? '-'));
        $this->newLine();

        // ───────── HISTORIAS CLÍNICAS ─────────
        $this->line('========================================');
        $this->info('📒 HISTORIAS CLÍNICAS');
        $this->line('========================================');

        if ($paciente->historiasClinicas->isEmpty()) {
            $this->comment('Este paciente todavía no tiene historias clínicas registradas.');
        } else {
            foreach ($paciente->historiasClinicas as $hc) {
                $this->line('----------------------------------------');
                $this->line('ID HC        : ' . $hc->id_hc);
                $this->line('Fecha        : ' . ($hc->fecha_consulta?->format('d/m/Y') ?? '-') .
                    ' ' . ($hc->hora_consulta ? substr($hc->hora_consulta, 0, 5) : ''));
                $this->line('Motivo       : ' . ($hc->motivo_consulta ?? '-'));
                $this->line('Dx principal : ' . ($hc->diagnostico_principal ?? '-'));
                $this->line('Tratamiento  : ' . ($hc->descripcion_tratamiento ?
                    mb_strimwidth($hc->descripcion_tratamiento, 0, 80, '...') : '-'));
                $this->line('Obs.         : ' . ($hc->observaciones ?
                    mb_strimwidth($hc->observaciones, 0, 80, '...') : '-'));
            }
        }

        $this->newLine();

        // ───────── TURNOS ─────────
        $this->line('========================================');
        $this->info('📅 TURNOS');
        $this->line('========================================');

        if ($paciente->turnos->isEmpty()) {
            $this->comment('No hay turnos registrados para este paciente.');
        } else {
            foreach ($paciente->turnos as $turno) {
                $this->line('----------------------------------------');
                $this->line('ID Turno     : ' . $turno->id_turno);
                $this->line('Fecha        : ' . ($turno->fecha_turno?->format('d/m/Y') ?? '-') .
                    ' ' . ($turno->hora_turno ? substr($turno->hora_turno, 0, 5) : ''));
                $this->line('Motivo       : ' . ($turno->motivo ?? '-'));
                $this->line('Estado       : ' . ($turno->estado ?? '-'));
                $this->line('Usuario ID   : ' . ($turno->id_usuario ?? '-'));
            }
        }

        $this->newLine();

        // ───────── ESTUDIOS ─────────
        $this->line('========================================');
        $this->info('🧪 ESTUDIOS');
        $this->line('========================================');

        if ($paciente->estudios->isEmpty()) {
            $this->comment('No hay estudios registrados para este paciente.');
        } else {
            foreach ($paciente->estudios as $estudio) {
                $this->line('----------------------------------------');
                $this->line('ID Estudio   : ' . $estudio->id_estudio);
                $this->line('Fecha subida : ' . ($estudio->ts_subida?->format('d/m/Y H:i') ?? '-'));
                $this->line('Tipo archivo : ' . ($estudio->tipo_archivo ?? '-'));
                $this->line('Archivo URL  : ' . ($estudio->archivo_url ?? '-'));
                $this->line('Descripción  : ' . ($estudio->descripcion ?
                    mb_strimwidth($estudio->descripcion, 0, 80, '...') : '-'));
            }
        }

        $this->newLine();
        $this->info('✅ Fin del resumen. Todo OK.');

        return self::SUCCESS;
    }
}
