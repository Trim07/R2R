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

    /**
     * @return array
     */
    function mapFieldsToArray(): array;

    /**
     * @return string
     */
    function getTableName(): string;

}