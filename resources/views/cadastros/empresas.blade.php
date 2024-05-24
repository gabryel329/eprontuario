@extends('layouts.app')
@section('content')
<main class="app-content">
    <div class="row user">
      <div class="col-md-12">
        <div class="profile">
          <div class="info"><img class="user-img" src="images/CamaraoEmpanado.jpg">
            <h4>{{ Auth::user()->name }}</h4>
          </div>
          <div class="cover-image"></div>
        </div>
    </div>
      <div class="col-md-3">
        <div class="tile p-0">
          <ul class="nav flex-column nav-tabs user-tabs">
            <li class="nav-item"><a class="nav-link active" href="#user-timeline" data-bs-toggle="tab">Dados da empresa</a></li>
          </ul>
        </div>
    </div>
    <div class="col-md-8">
        <div class="tab-content">        
            <div class="tab-pane active" id="user-timeline">
                <div class="tile user-timeline">
                    <h4 class="line">Dados</h4>
                    <form>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Nome da Empresa</label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="col-md-6">
                                <label>CNPJ</label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label>Email</label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="col-md-6">
                                <label>Telefone</label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Médico</label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="col-md-3">
                                <label>CRM</label>
                                <input class="form-control" type="text">
                            </div>
                            <div class="col-md-3">
                                <label>CPF</label>
                                <input class="form-control" type="text">
                            </div>
                            </div>
                        </div>
                        <div class="row mb-10">
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bi bi-check-circle-fill me-2"></i> Edit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Dados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="#">
                        <!-- Add your form fields here -->
                        <div class="row">
                            <div class="mb-3 ">
                                <label class="form-label">Nome</label>
                                <input class="form-control" name="name" type="text">
                            </div>
                            <div class="mb-3 ">
                                <label class="form-label">CNPJ</label>
                                <input class="form-control" name="sobrenome" type="text">
                            </div>
                            <div class="mb-3 ">
                                <label class="form-label">E-mail</label>
                                <input class="form-control" name="email" type="email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 ">
                                <label class="form-label">Telefone</label>
                                <input class="form-control" name="mobile" type="text">
                            </div>
                            <div class="mb-3 ">
                                <label class="form-label">Médico</label>
                                <input class="form-control" name="office_phone" type="text">
                            </div>
                            <div class="mb-3 ">
                                <label class="form-label">CRM</label>
                                <input class="form-control" name="home_phone" type="text">
                            </div>
                            <div class="mb-3 ">
                                <label class="form-label">CPF</label>
                                <input class="form-control" name="home_phone" type="text">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        
</main>
@endsection
