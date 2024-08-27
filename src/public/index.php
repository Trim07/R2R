<?php

use App\Services\Database\DatabaseManager;
use App\Modules\Customers\Repositories\CostumersRepository;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/bootstrap.php';


$pdo = DatabaseManager::getConnection();

$customerRepository = new CostumersRepository();
var_dump($customerRepository->findById(1));