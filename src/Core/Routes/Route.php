<?php

namespace App\Core\Routes;

/**
 * Class responsible for capturing information from requests
 */
class Route
{
    private string $method;
    private string $path;
    private $callback;

    public function __construct(string $method, string $path, callable $callback)
    {
        $this->method = $method;
        $this->path = $path;
        $this->callback = $callback;
    }

    /**
     * Get request method
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get request path
     *
     * @return string
     */
    public function getUri(): string
    {
        return $this->path;
    }

    /**
     * Get callback function, can be used to call a Controller function, for example
     *
     * @return callable
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }
}