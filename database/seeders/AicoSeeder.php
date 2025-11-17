<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AicoSeeder extends Seeder
{
    public function run(): void
    {
        // --- USUARIO BASE (AICO) ---
        DB::table('users')->insert([
            'dni'        => '56176515',
            'name'       => 'Javier',
            'apellido'   => 'Bonet',
            'telefono'   => '342-555111',
            'rol'        => 'odontologa',
            'email'      => 'javier@aico.test',
            'email_verified_at' => now(),
            'password'   => Hash::make('aico123'),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Obtener ID de ese usuario
        $usuarioId = DB::table('users')->where('dni', '56176515')->value('id');

        // --- PACIENTES ---
        DB::table('pacientes')->insert([
            [
                'dni' => '30111222',
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'fecha_nacimiento' => '1990-05-10',
                'telefono' => '3492-555111',
                'email' => 'juan@example.com',
                'obra_social' => 'OSDE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dni' => '30222333',
                'nombre' => 'María',
                'apellido' => 'Gómez',
                'fecha_nacimiento' => '1985-11-22',
                'telefono' => '342-444222',
                'email' => 'maria@example.com',
                'obra_social' => 'IAPOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'dni' => '30333444',
                'nombre' => 'Carlos',
                'apellido' => 'Sosa',
                'fecha_nacimiento' => '1978-04-15',
                'telefono' => '342-333444',
                'email' => 'carlos@example.com',
                'obra_social' => 'Swiss Medical',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // --- HISTORIAS CLÍNICAS ---
        DB::table('historias_clinicas')->insert([
            [
                'id_paciente'            => 1,
                'id_usuario'             => $usuarioId,
                'hora_consulta'          => '09:00:00',
                'motivo_consulta'        => 'Dolor en la muela superior derecha.',
                'diagnostico_principal'  => 'Caries profunda en molar superior.',
                'descripcion_tratamiento' => 'Tratamiento de conducto y analgésicos.',
                'observaciones'          => 'Paciente con antecedentes de sensibilidad.',
                'created_at'             => now(),
                'updated_at'             => now(),
            ],
            [
                'id_paciente'            => 2,
                'id_usuario'             => $usuarioId,
                'hora_consulta'          => '10:30:00',
                'motivo_consulta'        => 'Revisión general.',
                'diagnostico_principal'  => 'Sin hallazgos relevantes.',
                'descripcion_tratamiento' => 'Limpieza de rutina.',
                'observaciones'          => 'Se recomendó control anual.',
                'created_at'             => now(),
                'updated_at'             => now(),
            ],
            [
                'id_paciente'            => 3,
                'id_usuario'             => $usuarioId,
                'hora_consulta'          => '11:15:00',
                'motivo_consulta'        => 'Sangrado de encías.',
                'diagnostico_principal'  => 'Gingivitis leve.',
                'descripcion_tratamiento' => 'Higiene reforzada y enjuague bucal.',
                'observaciones'          => 'Control en 30 días.',
                'created_at'             => now(),
                'updated_at'             => now(),
            ],
        ]);

        // --- TURNOS ---
        DB::table('turnos')->insert([
            [
                'id_paciente' => 1,
                'dni_usuario' => '56176515', // DNI del user base
                'fecha_turno' => now()->addDays(1)->toDateString(),
                'hora_turno'  => '09:00:00',
                'motivo'      => 'Control post tratamiento de conducto.',
                'estado'      => 'pendiente',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id_paciente' => 2,
                'dni_usuario' => '56176515',
                'fecha_turno' => now()->addDays(2)->toDateString(),
                'hora_turno'  => '10:00:00',
                'motivo'      => 'Control anual.',
                'estado'      => 'pendiente',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id_paciente' => 3,
                'dni_usuario' => '56176515',
                'fecha_turno' => now()->addDays(3)->toDateString(),
                'hora_turno'  => '11:30:00',
                'motivo'      => 'Seguimiento gingivitis.',
                'estado'      => 'confirmado',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);

        // --- ESTUDIOS ---
        DB::table('estudios')->insert([
            [
                'id_paciente' => 1,
                'descripcion' => 'Radiografía panorámica inicial.',
                'archivo_url' => '/storage/estudios/paciente1_radiografia1.png',
                'tipo_archivo' => 'imagen',
                'ts_subida'   => now(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id_paciente' => 2,
                'descripcion' => 'Fotografía intraoral de control.',
                'archivo_url' => '/storage/estudios/paciente2_foto1.jpg',
                'tipo_archivo' => 'imagen',
                'ts_subida'   => now(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);

        // --- LOGS ---
        DB::table('logs')->insert([
            [
                'usuario_id' => $usuarioId,
                'nivel'      => 'INFO',
                'evento'     => 'Seeder AICO ejecutado',
                'descripcion' => 'Base de datos inicial cargada para pruebas del prototipo AICO.',
                'ip_origen'  => '127.0.0.1',
                'created_at' => now(),
            ],
        ]);
    }
}
