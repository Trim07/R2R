<?php

namespace App\Core\Routes\Interfaces;

use App\Core\Routes\Request;

/**
 * Interface will be used in class standardization
 */
interface RouterInterface
{

    /**
     * Will be used to standardize the retrieval of request information
     */
    public function addRoute(string $method, string $path, callable $callback): void;

    /**
     * It will be used to handle the request.
     */
    public function handleRequest(Request $request): void;
}