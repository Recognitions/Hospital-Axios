<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Eventos;

Route::get('/', [Eventos::class, 'index']);

Route::get('/cadastro', function(){
    return view('cadastro');
});

Route::get('/painel', function(){
    return view('painel');
});
Route::get('/painel/pacientes', [Eventos::class, 'pacientes']);
Route::get('pacientes',[Eventos::class, 'renderPatients']);
Route::post('/painel/pacientes', [Eventos::class, 'salvar'])->name('pacientes.salvar');
Route::post('/painel/pacientes/editar', [Eventos::class, 'editar'])->name('pacientes.editar');

Route::get('/painel/tabela', [Eventos::class, 'tabela']);


Route::get('/painel/pacientes/atenda/{id}', [Eventos::class, 'atenda']);

Route::get('/painel/pacientes/atender/{id}', [Eventos::class, 'atender']);
Route::post('/painel/pacientes/atender/{id}', [Eventos::class, 'concluir']);

Route::get('/painel/pacientes/remover/{id}', [Eventos::class, 'remover']);


Route::get('/painel/atendimentos', function(){
    return view('atendimentos');
});