<?php

namespace App\Core\Interfaces;

interface DatabaseServicesInterface
{

    /**
     * @param ModelInterface $model
     * @return ModelInterface
     */
    function insert(ModelInterface $model): ModelInterface;

    /**
     * @param ModelInterface $model
     * @return bool
     */
    function update(ModelInterface $model): bool;

    /**
     * @param ModelInterface $model
     * @return bool
     */
    function delete(ModelInterface $model): bool;
}
