@extends('layouts.app')

@section('title', 'Pacientes | AICO')
@section('header', 'Pacientes')

@section('content')
    <div class="aico-card mb-3">
        <div class="d-flex flex-column flex-md-row justify-content-between gap-2">
            <div>
                <h2 class="h5 mb-1">Listado de pacientes</h2>
                <p class="text-muted small mb-0">
                    Gestioná los pacientes y accedé rápido a sus historias clínicas.
                </p>
            </div>
            <div class="d-flex gap-2">
                <form method="GET" action="{{ route('pacientes.index') }}" class="d-flex gap-2">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm"
                        placeholder="Buscar por DNI o nombre...">
                    <select name="obra_social" class="form-select form-select-sm">
                        <option value="">Obra social (todas)</option>
                        {{-- llenar esto dinámicamente --}}
                    </select>
                    <button class="btn btn-sm btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                <a href="{{ route('pacientes.create') }}" class="btn btn-sm btn-aico-primary">
                    <i class="bi bi-plus-circle me-1"></i> Nuevo paciente
                </a>
            </div>
        </div>
    </div>

    <div class="aico-card">
        @if ($pacientes->isEmpty())
            <p class="text-muted mb-0">No hay pacientes cargados todavía.</p>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Obra social</th>
                            <th>Teléfono</th>
                            <th>Última HC</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pacientes as $paciente)
                            <tr>
                                <td>{{ $paciente->dni }}</td>
                                <td>{{ $paciente->nombre }} {{ $paciente->apellido }}</td>
                                <td>{{ $paciente->obra_social ?? '-' }}</td>
                                <td>{{ $paciente->telefono ?? '-' }}</td>
                                <td>
                                    {{-- acá después podemos calcular la fecha de la última historia clínica --}}
                                    <span class="badge bg-light text-muted aico-badge-pill">-</span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('pacientes.show', $paciente) }}" class="btn btn-outline-secondary"
                                            title="Ver ficha">
                                            <i class="bi bi-person-vcard"></i>
                                        </a>
                                        <a href="{{ route('pacientes.edit', $paciente) }}" class="btn btn-outline-secondary"
                                            title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="{{ route('pacientes.historias.index', $paciente) }}"
                                            class="btn btn-outline-primary" title="Historia clínica">
                                            <i class="bi bi-journal-medical"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pacientes->links() }}
            </div>
        @endif
    </div>
@endsection
