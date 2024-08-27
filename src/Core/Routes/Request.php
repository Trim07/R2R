<?php

namespace App\Core\Routes;


/**
 * Request class
 */
class Request
{
    private string $method;
    private array $data;
    private array $queryParams;
    private array $postParams;
    private array $headers;
    private array $cookies;

    private string $path;

    public function __construct()
    {
        $this->headers = $this->parseHeaders();
        $this->cookies = $_COOKIE;
        $this->queryParams = $_GET;
        $this->postParams = $_POST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = $_SERVER['REQUEST_URI'];

        if ($this->isJsonRequest()) {
            $this->data = json_decode(file_get_contents('php://input'), true) ?? [];
        } else {
            $this->data = $this->postParams;
        }
    }

    /**
     * Return ALL DATA from request
     *
     * @return array
     */
    public function all(): array
    {
        return array_merge($this->queryParams, $this->postParams, $this->data);
    }

    /**
     * Return DATA from GET request or can be used to return a specific field value
     *
     * @param string|null $key
     * @return array|mixed|null
     */
    public function getQuery(string $key = null): mixed
    {
        return $key ? ($this->queryParams[$key] ?? null) : $this->queryParams;
    }

    /**
     * Return POST data
     *
     * @param string|null $key
     * @return array|mixed|null
     */
    public function getPost(string $key = null): mixed
    {
        return $key ? ($this->postParams[$key] ?? null) : $this->postParams;
    }

    /**
     * Return info from HEADERS
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Return COOKIES
     *
     * @return array
     */
    public function getCookies(): array
    {
        return $this->cookies;
    }

    /**
     * Check if the current request type is JSON FORMAT
     *
     * @return bool
     */
    private function isJsonRequest(): bool
    {
        return isset($_SERVER['CONTENT_TYPE']) && str_starts_with($_SERVER['CONTENT_TYPE'], 'application/json');
    }

    private function parseHeaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $headerKey = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
                $headers[$headerKey] = $value;
            }
        }
        return $headers;
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
     * get request method
     * @return string
     */
    public function getUri(): string
    {
        return $_SERVER["REQUEST_URI"];
    }
}
