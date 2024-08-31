<?php
require_once 'index.php';
require_once __DIR__ . '/../../Utils/Helper.php';

checkAuthentication();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R2R - Lista de clientes</title>
    <link rel="icon" href="/images/logo.ico" sizes="16x16" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="/resources/css/customers/index.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container-fluid">

            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="/images/logo.svg" alt="Logo" width="60" height="60" class="d-inline-block align-text-top">
                <span class="ms-2">Ready To Register</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="btn btn-dark btn-sm" href="#" onclick="logoutUser()">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid mt-5">

        <div class="header d-flex justify-content-between align-items-center mb-4">
            <h2>Lista de clientes</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customerModal">Novo cliente</button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 10%;">#</th>
                        <th>Nome</th>
                        <th style="width: 15%;">Telefone</th>
                        <th style="width: 15%;">CPF</th>
                        <th style="width: 15%;">RG</th>
                        <th style="width: 15%;">Data Nascimento</th>
                        <th style="width: 5%;">Detalhes</th>
                    </tr>
                </thead>
                <tbody id="customers-table-body">
                    <!-- Dados dos clientes serão injetados por JS -->
                </tbody>
            </table>
        </div>
    </div>

    <form id="customerForm">
        <div class="modal fade modal-fullscreen" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customerModalLabel">Cadastro e Detalhes do Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="customer-tab" data-bs-toggle="tab" href="#customer" role="tab" aria-controls="customer" aria-selected="true">Dados do Cliente</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="addresses-tab" data-bs-toggle="tab" href="#addresses" role="tab" aria-controls="addresses" aria-selected="false">Endereços</a>
                            </li>
                        </ul>
                        <!-- Tab content -->
                        <div class="tab-content mt-3" id="myTabContent">
                            <!-- Customer Data Tab -->
                            <div class="tab-pane fade show active" id="customer" role="tabpanel">
                                <div class="row mt-2">
                                    <input type="hidden" name="customer[id]">
                                    <div class="col-4">
                                        <label for="customerModal-name" class="form-label">Nome</label>
                                        <input type="text" class="form-control" id="customerModal-name" name="customer[name]" minlength="5" maxlength="100" required>
                                    </div>

                                    <div class="col-4">
                                        <label for="customerModal-phone" class="form-label">Telefone</label>
                                        <input type="string" class="form-control phone" id="customerModal-phone" name="customer[phone]" required>
                                    </div>

                                    <div class="col-4">
                                        <label for="customerModal-cpf" class="form-label">CPF</label>
                                        <input type="string" class="form-control" id="customerModal-cpf" name="customer[cpf]" required>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-4">
                                        <label for="customerModal-rg" class="form-label">RG</label>
                                        <input type="string" class="form-control rg" id="customerModal-rg" name="customer[rg]" required>
                                    </div>

                                    <div class="col-4">
                                        <label for="customerModal-birthday" class="form-label">Data nascimento</label>
                                        <input type="date" class="form-control" id="customerModal-birthday" name="customer[birthday]" min="1900-01-01" max="2024-01-01" required>
                                    </div>
                                </div>
                            </div>
                            <!-- Addresses Tab -->
                            <div class="tab-pane fade" id="addresses" role="tabpanel" aria-labelledby="addresses-tab">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="addressesTable">
                                        <thead>
                                            <tr>
                                                <th>Identificação</th>
                                                <th>Rua</th>
                                                <th>Número</th>
                                                <th>Bairro</th>
                                                <th>Cidade</th>
                                                <th>U.F</th>
                                                <th>País (Sigla)</th>
                                                <th>CEP</th>
                                                <th>Complemento</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody id="addressesTableBody">
                                            <!-- Address rows will be appended here -->
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-primary" id="addAddress">Adicionar Endereço</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer row">
                        <div class="row">
                            <div class="col-4">
                                <button type="button" class="btn btn-danger float-start d-none" id="delete-customer">Remover</button>
                            </div>
                            <div class="col-8">
                                <button type="submit" class="btn btn-primary float-end ms-2" id="saveCustomerBtn">Salvar</button>
                                <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="/resources/js/customers/index.js"></script>
</body>

</html>