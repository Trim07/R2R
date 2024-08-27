<?php

use Trimcorp\R2r\services\Database\DatabaseManager;
use Trimcorp\R2r\app\modules\Customers\Repositories\CostumersRepository;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/bootstrap.php';


$pdo = DatabaseManager::getConnection();

$customerRepository = new CostumersRepository();
var_dump($customerRepository->findById(1));