<?php


// Inicia a sessão se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkAuthentication(): void {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login.php');
        exit();
    }
}

function redirectTo(string $url): void {
    header('Location: ' . $url);
    exit();
}

function hashPassword(string $password): string {
    return password_hash($password, PASSWORD_BCRYPT);
}

function startSession(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}