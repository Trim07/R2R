<?php

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/bootstrap.php';

if (basename($_SERVER['PHP_SELF']) == 'index.php') {
    header('Location: customers/index.php');
    exit;
}