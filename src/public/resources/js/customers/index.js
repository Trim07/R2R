$(document).ready(function() {
    axios.defaults.withCredentials = true;
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

    $(document).ready(function() {
        $('#customer-list-table').DataTable({
            "paging": true,         // Ativa a paginação
            "searching": true,      // Ativa o campo de busca
            "ordering": true,       // Ativa a ordenação das colunas
            "info": true,           // Mostra informações sobre o número de entradas
            "lengthMenu": [5, 10, 25, 50], // Número de entradas por página
            "language": {
                "lengthMenu": "Mostrar _MENU_ entradas por página",
                "zeroRecords": "Nenhum registro encontrado",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "infoFiltered": "(filtrado de _MAX_ registros no total)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                },
            }
        });
    });

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
                text: `Ocorreu um erro ao buscar dados dos clientes:\n${error.response.data.error || ""}`,
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

$('#customerModal').on('shown.bs.modal', function() {
    setInputMasks();
});

$('#customerModal').on('hidden.bs.modal', function() {
    // clean form
    $('#customerForm').trigger('reset');

    // remove id from save customerModal button
    $('input[name="customer[id]"]').val('');

    // clean address table
    $('#addressesTable tbody').html('');

    $('#delete-customer').addClass("d-none"); // hide "Remover" button
    setInputMasks();
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
                location.reload();
            }, 1000);
        })
        .catch(function(error) {
            Swal.fire({
                title: "Ops...",
                text: `Ocorreu um erro ao salvar o cliente:\n${error.response.data.error || ""}`,
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
                            text: "O cliente foi removido com sucesso.",
                            icon: "success",
                            button: "OK",
                        })
                        $('#customerModal').modal("hide");
                        loadCustomers();
                    })
                    .catch(function(error) {
                        Swal.fire({
                            title: "Ops...",
                            text: `Ocorreu um erro ao remover o cliente.\n${error.response.data.error || ""}`,
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
                text: `Ocorreu um erro ao sair do sistema. \n${error.response.data.error || ""}`,
                icon: "error",
                button: "OK",
            });
        });
}