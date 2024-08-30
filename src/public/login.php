<?php
require_once 'index.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="col-12 mt-5">
                <h1>R2R - Ready to Register</h1>
            </div>
            <h3 class="mt-5">Login</h3>
            <hr>
            <form id="loginForm">
                <div class="form-group">
                    <label for="username">E-mail</label>
                    <input type="text" class="form-control" id="email" name="email" maxlength="100" required>
                </div>
                <div class="form-group mt-1">
                    <label for="password">Senha</label>
                    <input type="password" class="form-control" id="password" name="password" maxlength="100" required>
                </div>
                <div class="row mt-4">
                    <div class="col-6">
                        <span>
                            Ainda não tem uma conta?
                            <a href="/register.php">Registre-se</a>
                        </span>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary float-end">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(event) {
            event.preventDefault();
            axios.defaults.withCredentials = true;

            let formData = new FormData(this);
            axios.post('/api/users/login', formData, {
                headers: {
                    'Content-Type': 'application/json'
                },
                withCredentials: true
            })
            .then(response => {
                window.location.href = "/customers/index.php";
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: "Ops...",
                    text: `Ocorreu um erro durante o login:\n${error}`,
                });
            });
        });
    });
</script>
</body>
</html>
