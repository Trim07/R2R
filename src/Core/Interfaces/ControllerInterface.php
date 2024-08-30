<?php

namespace App\Core\Interfaces;


/**
 * Interface ControllerInterface
 * Define padrões para controllers.
 */
interface ControllerInterface
{
    /**
     * Returns all records.
     *
     * @return void
     */
    public function index(): void;

    /**
     * Creates a new record.
     *
     * @param array $data
     * @return void
     */
    public function create(array $data): void;

    /**
     * Get a specific record by ID.
     *
     * @param array $data
     * @return void
     */
    public function show(array $data): void;

    /**
     * Updates a record by ID.
     *
     * @param array $data
     * @return void
     */
    public function update(array $data): void;

    /**
     * Delete a record by ID.
     *
     * @param array $data
     * @return void
     */
    public function delete(array $data): void;
}