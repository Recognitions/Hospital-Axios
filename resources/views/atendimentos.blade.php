@extends('layout.app')
@section('title','Login')

@section('content')
    <header class="d-flex justify-content-center py-3 shadow">
        <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link" href="/painel">Painel</a></li>
            <li class="nav-item"><a class="nav-link" href="/painel/pacientes">Pacientes</a></li>
            <li class="nav-item"><a class="nav-link active">Atendimentos</a></li>
        </ul>
    </header>
    <b>Atendimentos</b>
@endsection