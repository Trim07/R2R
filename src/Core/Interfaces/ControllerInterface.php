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
     * @return void
     */
    public function create(): void;

    /**
     * Get a specific record by ID.
     *
     * @param int $id
     * @return void
     */
    public function show(int $id): void;

    /**
     * Updates a record by ID.
     *
     * @param int $id
     * @return void
     */
    public function update(int $id): void;

    /**
     * Delete a record by ID.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
}