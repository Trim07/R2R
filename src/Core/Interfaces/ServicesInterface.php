<?php

namespace App\Core\Interfaces;

interface ServicesInterface
{

    /**
     * @param array $data
     * @return void
     */
    function create(array $data): void;

    /**
     * @param array $data
     * @return void
     */
    function update(array $data): void;

    /**
     * @param array $data
     * @return void
     */
    function delete(array $data): void;

}