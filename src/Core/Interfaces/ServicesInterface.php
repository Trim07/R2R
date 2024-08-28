<?php

namespace App\Core\Interfaces;

interface ServicesInterface
{

    function create(ModelInterface $data): void;

    function update(ModelInterface $data): void;

    function delete(ModelInterface $data): void;

}