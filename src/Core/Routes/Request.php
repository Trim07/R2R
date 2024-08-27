<?php

namespace App\Core\Routes;


/**
 * Request class
 */
class Request
{
    private string $method;
    private string $path;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    /**
     * get request method
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get request uri
     *
     * @return string
     */
    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Get request post data
     *
     * @return array
     */
    public function getPostData(): array
    {
        return $_POST;
    }

    /**
     * Get request get params
     *
     * @return array
     */
    public function getQueryParams(): array
    {
        return $_GET;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
