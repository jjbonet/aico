@extends('layouts.app')

@section('title', 'Historia clínica | AICO')
@section('header', 'Historia clínica de ' . $paciente->nombre . ' ' . $paciente->apellido)

@section('content')
    <div class="aico-card mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h5 mb-1">
                    {{ $paciente->nombre }} {{ $paciente->apellido }} (DNI {{ $paciente->dni }})
                </h2>
                <p class="text-muted small mb-0">
                    Obra social: {{ $paciente->obra_social ?? 'No registrada' }}
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('pacientes.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Volver a pacientes
                </a>
                {{-- Más adelante: botón "Nueva entrada de historia clínica" --}}
            </div>
        </div>
    </div>

    <div class="aico-card">
        <h3 class="h6 mb-3">Entradas de historia clínica</h3>

        @if ($historias->isEmpty())
            <p class="text-muted mb-0">
                Este paciente todavía no tiene historias clínicas cargadas.
            </p>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Motivo</th>
                            <th>Diagnóstico principal</th>
                            <th>Tratamiento</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historias as $hc)
                            <tr>
                                <td>{{ optional($hc->fecha_consulta)->format('d/m/Y') ?? '-' }}</td>
                                <td>{{ $hc->hora_consulta ? \Illuminate\Support\Str::of($hc->hora_consulta)->limit(5, '') : '-' }}
                                </td>
                                <td>{{ $hc->motivo_consulta ?? '-' }}</td>
                                <td>{{ $hc->diagnostico_principal ?? '-' }}</td>
                                <td>
                                    {{ $hc->descripcion_tratamiento ? \Illuminate\Support\Str::limit($hc->descripcion_tratamiento, 60) : '-' }}
                                </td>
                                <td>
                                    {{ $hc->observaciones ? \Illuminate\Support\Str::limit($hc->observaciones, 60) : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
