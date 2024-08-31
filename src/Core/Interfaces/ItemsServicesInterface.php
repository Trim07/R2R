<?php

namespace App\Core\Interfaces;

interface ItemsServicesInterface
{

    /**
     * @param array $data
     * @param int $father_id
     * @return void
     */
    function create(array $data, int $father_id): void;

    /**
     * @param array $data
     * @param int $father_id
     * @return void
     */
    function update(array $data, int $father_id): void;

    /**
     * @param int $father_id
     * @return bool
     */
    function deleteAll(int $father_id): bool;

    /**
     * @param array $data
     * @return void
     */
    function delete(array $data): void;

}