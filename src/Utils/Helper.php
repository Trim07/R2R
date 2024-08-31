<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkAuthentication(): void {
    if (!isset($_SESSION['user'])) {
        redirectTo("/login.php");
    }
}

function redirectTo(string $url): void {
    header('Location: ' . $url);
    exit();
}