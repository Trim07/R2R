<?php

namespace App\Core\Interfaces;

interface ModelInterface{

    /**
     * Map field from array to model fields
     *
     * @param array $array
     * @return self
     */
    static function mapFieldFromArray(array $array): self;

    function mapFieldsToArray(): array;

    function getTableName(): string;

}