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
    <style>
        .navbar-custom {
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
        }

        .navbar-custom .navbar-brand {
            color: #343a40;
            height: 50px;
            display: flex;
            align-items: center;
        }

        .navbar-custom .navbar-nav .nav-item .nav-link {
            padding: 0.5rem 1rem;
        }

        .navbar-custom .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
        }

        .navbar-custom .btn-outline-primary:hover {
            background-color: #007bff;
            color: #ffffff;
        }
    </style>
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
                            <div class="tab-pane fade show active" id="customer" role="tabpanel" aria-labelledby="customer-tab">
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

    <script>
        $(document).ready(function() {
            // axios.defaults.withCredentials = true;
            axios.interceptors.response.use(
                (response) => response,
                (error) => {
                    if (
                        error.response &&
                        (error.response.status === 419 || error.response.status === 401)
                    ) {
                        window.location.href = "/login.php";
                    }
                    return Promise.reject(error);
                }
            );

            loadCustomers();
            $('input[type="date"], input[type="month"]').prop('max', '9999-12-31');
        });

        function loadCustomers() {
            axios.get('/api/customers')
                .then(function(response) {
                    const customers = response.data;
                    const tableBody = $('#customers-table-body');

                    tableBody.empty(); // Clean the table

                    if (customers.length === 0) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Ainda não temos nada por aqui...',
                            text: 'Nenhum cliente foi encontrado',
                        });
                        return;
                    }

                    customers.forEach((partner, index) => {
                        const row = `
                            <tr>
                                <td><input class="form-control" value="${index + 1}" disabled></td>
                                <td><input class="form-control" value="${partner.name}" disabled></td>
                                <td><input class="form-control phone" value="${partner.phone}" disabled></td>
                                <td><input class="form-control cpf" value="${partner.cpf}" disabled></td>
                                <td><input class="form-control rg" value="${partner.rg}" disabled></td>
                                <td><input type="date" class="form-control" value="${partner.birthday}" disabled></td>
                                <td>
                                    <a class="btn btn-primary btn-sm" onclick="loadCustomerData(${partner.id})">Detalhes</a>
                                </td>
                            </tr>
                        `;
                        tableBody.append(row);
                    });
                    setInputMasks();
                })
                .catch(function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: "Ops...",
                        text: `Ocorreu um erro ao buscar dados dos clientes:\n${error.response.data.error}`,
                    });
                });
        }

        // Load customer details data
        let addressIndex = 0;

        function loadCustomerData(customerId) {
            axios.get(`/api/customers/${customerId}`)
                .then(function(response) {

                    const customer_data = response.data.customer;
                    const addresses_data = response.data.addresses;

                    // Clean all addresses fields
                    $('#addressesTable tbody').empty();

                    // Fill customer details fields
                    $('#customerModal-name').val(customer_data.name);
                    $('#customerModal-phone').val(customer_data.phone);
                    $('#customerModal-cpf').val(customer_data.cpf);
                    $('#customerModal-rg').val(customer_data.rg);
                    $('#customerModal-birthday').val(customer_data.birthday);

                    // Add address row
                    addresses_data.forEach((address, index) => {
                        addAddressRow(index, address)
                    });

                    // Update address index
                    addressIndex = addresses_data.length;

                    $('input[name="customer[id]"]').val(customer_data.id);

                    $('#delete-customer').removeClass("d-none"); // show "Remover" button
                    setInputMasks();
                    $('#customerModal').modal('show');
                })
                .catch(function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: "Ops...",
                        text: `Ocorreu um erro ao buscar dados do cliente:\n${error.response.data.error}`,
                    });
                });
        }

        // Function to add a new address row
        function addAddressRow(index, address = {}) {

            const addressRow = `
                    <tr id="address_row_${index}">
                        <td><input type="text" class="form-control" name="addresses[${index}][name]" maxlength="30" value="${address.name || ''}" required></td>
                        <td><input type="text" class="form-control" name="addresses[${index}][street]" maxlength="50" value="${address.street || ''}" required></td>
                        <td><input type="text" class="form-control" name="addresses[${index}][number]" maxlength="10" value="${address.number || ''}" required></td>
                        <td><input type="text" class="form-control" name="addresses[${index}][neighborhood]" maxlength="30" value="${address.neighborhood || ''}" required></td>
                        <td><input type="text" class="form-control" name="addresses[${index}][city]" maxlength="50" value="${address.city || ''}" required></td>
                        <td><input type="text" class="form-control" name="addresses[${index}][state]" maxlength="4" value="${address.state || ''}" required></td>
                        <td><input type="text" class="form-control" name="addresses[${index}][country]" maxlength="3" value="${address.country || ''}" required></td>
                        <td><input type="text" class="form-control cep" name="addresses[${index}][zipcode]" maxlength="8" value="${address.zipcode || ''}" required></td>
                        <td><input type="text" class="form-control" name="addresses[${index}][complement]" maxlength="50" value="${address.complement || ''}"></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-address" onclick="removeAddress(this)">Remover</button></td>
                    </tr>`;

            $('#addressesTableBody').append(addressRow);
        }

        // Add address row
        $('#addAddress').on('click', function() {
            addAddressRow(addressIndex);
            setInputMasks();
            addressIndex++;
        });

        function removeAddress(element) {
            let closest_table_body_row = $(element.target).length ? $(element.target).closest('tr') : $(element).closest('tr');
            closest_table_body_row.remove();
        }

        $('#customerModal').on('hidden.bs.modal', function() {
            // clean form
            $('#customerForm').trigger('reset');

            // remove id from save customerModal button
            $('input[name="customer[id]"]').val('');

            // clean address table
            $('#addressesTable tbody').html('');

            $('#delete-customer').addClass("d-none"); // hide "Remover" button
        });

        $('#customerForm').on('submit', function(event) {
            event.preventDefault();

            cleanCustomerFieldsBeforeSubmit();

            let formData = new FormData(this);
            let method = $('input[name="customer[id]"]').val().length ? "PUT" : "POST";

            axios({
                    method: method,
                    url: '/api/customers',
                    data: formData,
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    withCredentials: true
                })
                .then(function(response) {
                    Swal.fire({
                        title: "Sucesso",
                        text: "Cliente salvo com sucesso!",
                        icon: "success",
                        button: "OK",
                    });
                    setTimeout(() => {
                        // location.reload();
                    }, 1000);
                })
                .catch(function(error) {
                    Swal.fire({
                        title: "Ops...",
                        text: `Ocorreu um erro ao salvar o cliente:\n${error.response.data.error}`,
                        icon: "error",
                        button: "OK",
                    });
                });

            setInputMasks();
        });

        $('#delete-customer').on('click', function() {
            let customerId = $('input[name="customer[id]"]').val();

            Swal.fire({
                    title: "Tem certeza?",
                    text: "Você não poderá recuperar esse cliente depois!",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: "Voltar",
                    confirmButtonText: "Sim, quero remover",
                    confirmButtonColor: "#cd0404",
                    dangerMode: true,
                    reverseButtons: true,
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`/api/customers/${customerId}`)
                            .then(function(response) {
                                Swal.fire({
                                    title: "Tudo certo!",
                                    text: "O cliente foi deletado com sucesso.",
                                    icon: "success",
                                    button: "OK",
                                })
                                loadCustomers();
                            })
                            .catch(function(error) {
                                Swal.fire({
                                    title: "Ops...",
                                    text: `Ocorreu um erro ao remover o cliente.\n${error.response.data.error}`,
                                    icon: "error",
                                    button: "OK",
                                });
                            });
                    }
                });
        });

        function setInputMasks() {
            $('.phone').mask('(00) 00000-0000');
            $('.cpf').mask('000.000.000-00');
            $('.rg').mask('00.000.000-00');
            $('.cep').mask('00000-000');

            $('#customerForm').find('.cpf, .rg, .phone, .cep').each((index, input) => {
                $(input).trigger('input');
            });
        }

        function cleanCustomerFieldsBeforeSubmit() {
            $('#customerForm').find('.cpf, .rg, .phone, .cep').each((index, input) => {
                $(input).unmask();
            });
        }

        function logoutUser() {
            axios.post('/api/users/logout')
                .then(function(response) {
                    Swal.fire({
                        title: "Sucesso",
                        text: "Logout realizado com sucesso!",
                        icon: "success",
                        confirmButtonText: "Ok",
                    });
                    setTimeout(() => {
                        window.location.href = "/login.php";
                    }, 1000);
                })
                .catch(function(error) {
                    Swal.fire({
                        title: "Ops...",
                        text: `Ocorreu um erro ao sair do sistema. \n${error.response.data.error}`,
                        icon: "error",
                        button: "OK",
                    });
                });
        }
    </script>
</body>

</html>