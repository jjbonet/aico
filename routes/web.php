<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\HistoriaClinicaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Raíz → manda directo a pacientes
Route::redirect('/', '/pacientes');

// PACIENTES (CRUD básico por ahora)
Route::resource('pacientes', PacienteController::class)->only([
    'index',   // GET  /pacientes
    'create',  // GET  /pacientes/create
    'show',    // GET  /pacientes/{paciente}
    'edit',    // GET  /pacientes/{paciente}/edit

]);

// HISTORIAS CLÍNICAS anidadas en PACIENTES
Route::resource('pacientes.historias', HistoriaClinicaController::class)->only([
    'index',   // GET  /pacientes/{paciente}/historias
    'create',  // GET  /pacientes/{paciente}/historias/create
    'store',   // POST /pacientes/{paciente}/historias
]);
