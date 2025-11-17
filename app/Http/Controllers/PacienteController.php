<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Paciente::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('dni', 'like', "%{$q}%")
                    ->orWhere('nombre', 'like', "%{$q}%")
                    ->orWhere('apellido', 'like', "%{$q}%");
            });
        }

        if ($request->filled('obra_social')) {
            $query->where('obra_social', $request->obra_social);
        }

        $pacientes = $query
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(10);

        return view('pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function show(Paciente $paciente)
    {
        return view('pacientes.show', compact('paciente'));
    }

    public function edit(Paciente $paciente)
    {
        return view('pacientes.edit', compact('paciente'));
    }

    // faltan los otros metodos
    // store(), update(), destroy() para CRUD completo
}
