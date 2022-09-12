@extends('layout.app')
@section('title','Login')

@section('content')
    <header class="d-flex justify-content-center py-3 shadow">
        <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link" href="/painel">Painel</a></li>
            <li class="nav-item"><a class="nav-link active">Pacientes</a></li>
            <li class="nav-item"><a class="nav-link">Atendimentos</a></li>
        </ul>
    </header>
    <div class="pacientes"><br>
        <div class="col-3">
            <h2>Registrar Paciente</h2>
            <form action="/painel/pacientes" method="POST" id="salvarPaciente" enctype="multipart/form-data">
                @csrf
                <div>
                    <i style="margin-left:3px;">Nome Completo</i>
                    <input type="text" placeholder="" name="nome" id="nome" class="form-control" required>
                    <i style="margin-left:3px;">CPF</i>
                    <input type="text" minlength="14" maxlength="14" placeholder="000.000.000-00" class="form-control" name="cpf" id="inputCPF" pattern="[0-9.-]+$" required>
                    <div>
                        <i style="margin-left:3px;">Contato</i>
                        <input type="text" minlength="14" maxlength="14" placeholder="(00)90000-0000" name="wpp" class="form-control" id="inputWPP" pattern="[0-9-()]+$" required>
                    </div>
                    <i style="margin-left:3px;">Data de Nascimento</i>
                    <input type="date" class="form-control" name="nasc" id="inputDate" required>
                    <div class="mb-3">
                        <i for="formFile" class="form-label">Foto do Paciente (opcional)</i>
                        <input class="form-control" type="file" name="foto" id="formFile">
                    </div>
                </div>
                <input type="submit" class="btn btn-primary" id="envipaci">
            </form>
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Pesquisar pacientes" aria-label="Username" id="pesquisar">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nome</th>
                        <th>Idade</th>
                        <th>CPF</th>
                        <th>Contato</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tabela">
                    
                </tbody>
            </table>
        </div>
    </div>
    <div id="editArea" class="editArea">
        <form action="/painel/pacientes/editar" class="row g-3" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-header border-bottom-0">
                        <h5 class="modal-title">Editar Paciente</h5>
                        <button type="button" id="closeEditArea" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0">
                        <input type="hidden" name="id" id="editarID">
                        <div>
                            <i style="margin-left:3px;" >Nome Completo</i>
                            <input type="text" placeholder="" name="nome" id="editarNome" class="form-control" required="">
                            <i style="margin-left:3px;">CPF</i>
                            <input type="text" maxlength="14" placeholder="000.000.000-00" class="form-control" name="cpf" id="editarCPF" pattern="[0-9.-]+$" required="">
                            <div>
                                <i style="margin-left:3px;">Contato</i>
                                <input type="text" maxlength="14" placeholder="(00)90000-0000" name="wpp" class="form-control" id="editarWPP" pattern="[0-9-()]+$" required="">
                            </div>
                            <i style="margin-left:3px;">Data de Nascimento</i>
                            <input type="date" class="form-control" name="nasc" id="editarIdade" required="" min="1900-01-01" max="2021-07-13">
                            <div class="mb-3">
                                <i for="formFile" class="form-label">Foto do Paciente (opcional)</i>
                                <input class="form-control" type="file" name="foto" id="formFile">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer flex-column border-top-0">
                        <input type="submit" class="btn btn-lg btn-primary w-100 mx-0 mb-2" value="Salvar Alterações">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection