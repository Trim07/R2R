<?php

use Trimcorp\R2r\services\Database\DatabaseManager;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../configs/bootstrap.php';


$pdo = DatabaseManager::getConnection();
