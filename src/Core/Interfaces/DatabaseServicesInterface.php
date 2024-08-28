<?php

namespace App\Core\Interfaces;

interface DatabaseServicesInterface
{

    function insert(ModelInterface $model): bool;

    function update(ModelInterface $model): bool;

    function delete(ModelInterface $model): bool;
}
