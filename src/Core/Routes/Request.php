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

        // Captura dados JSON do corpo da requisição, se disponível
        if ($this->isJsonRequest()) {
            $this->data = json_decode(file_get_contents('php://input'), true) ?? [];
        } else {
            $this->data = $this->postParams;
        }
    }

    public function all(): array
    {
        return array_merge($this->queryParams, $this->postParams, $this->data);
    }

    public function getQuery(string $key = null)
    {
        return $key ? ($this->queryParams[$key] ?? null) : $this->queryParams;
    }

    public function getPost(string $key = null)
    {
        return $key ? ($this->postParams[$key] ?? null) : $this->postParams;
    }

    public function getJson(string $key = null)
    {
        return $key ? ($this->data[$key] ?? null) : $this->data;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getCookies(): array
    {
        return $this->cookies;
    }

    private function isJsonRequest(): bool
    {
        return isset($_SERVER['CONTENT_TYPE']) && strpos($_SERVER['CONTENT_TYPE'], 'application/json') === 0;
    }

    private function parseHeaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
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
    public function getPath(): string
    {
        return $this->path;
    }

    public function getUri()
    {
        return $_SERVER["REQUEST_URI"];
    }
}
