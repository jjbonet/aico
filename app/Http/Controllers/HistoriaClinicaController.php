<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\HistoriaClinica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HistoriaClinicaController extends Controller
{
    // GET /pacientes/{paciente}/historias
    public function index(Paciente $paciente)
    {
        $historias = $paciente->historiasClinicas()
            ->orderByDesc('fecha_consulta')
            ->orderByDesc('created_at')
            ->get();

        return view('historias.index', compact('paciente', 'historias'));
    }

    // GET /pacientes/{paciente}/historias/create
    public function create(Paciente $paciente)
    {
        return view('historias.create', compact('paciente'));
    }

    // POST /pacientes/{paciente}/historias
    public function store(Request $request, Paciente $paciente)
    {
        $data = $request->validate([
            'fecha_consulta'          => ['nullable', 'date'],
            'hora_consulta'           => ['nullable'],
            'motivo_consulta'         => ['required', 'string', 'max:255'],
            'diagnostico_principal'   => ['nullable', 'string', 'max:255'],
            'descripcion_tratamiento' => ['nullable', 'string'],
            'observaciones'           => ['nullable', 'string'],
        ]);

        $data['id_paciente'] = $paciente->id_paciente;
        // Si hay usuario logueado, usamos su ID; si no, dejamos 1 como usuario "sistema" temporal.. volver aca
        $data['id_usuario'] = Auth::check() ? Auth::id() : 1;


        HistoriaClinica::create($data);

        return redirect()
            ->route('pacientes.historias.index', $paciente)
            ->with('status', 'Historia clínica registrada correctamente.');
    }
}
