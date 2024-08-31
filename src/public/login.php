<?php
require_once 'index.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R2R - Login</title>
    <link rel="icon" href="/images/logo.ico" sizes="16x16" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="/resources/css/users/login.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-dark">
                        <div class="text-center">
                            <div class="col-12 mt-2">
                                <img style="width: 7em; height: 7em;" src="/images/logo.svg" alt="logotipo-r2r">
                            </div>
                            <div class="row text-center mt-3">
                                <h3 class="fw-bold text-white">Ready To Register</h3>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form id="loginForm">
                            <h4 class="text-center mb-4">Login</h4>
                            <div class="row mb-3">
                                <label for="email" class="col-md-2 col-form-label text-md-end">E-mail</label>

                                <div class="col-md-9">
                                    <input type="email" class="form-control" id="email" name="email" maxlength="100" autofocus required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password" class="col-md-2 col-form-label text-md-end">Senha</label>

                                <div class="col-md-9">
                                    <input type="password" class="form-control" id="password" name="password" minlength="5" maxlength="100" required>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-5">
                                    <button type="submit" class="btn btn-dark">
                                        Entrar
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <span>
                                    Ainda não tem uma conta?
                                    <a class="btn btn-primary btn-sm" href="/register.php">Registre-se</a>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="/resources/js/users/login.js"></script>
</body>
</html>