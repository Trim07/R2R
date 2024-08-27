<?php

namespace App\Core\Routes;

use App\Core\Routes\Interfaces\RouterInterface;

/**
 * Class responsible for managing routes and directing them to their respective destinations
 */
class Router implements RouterInterface
{
    private array $routes = [];
    private array $params = [];

    /**
     * Used for an object of type Route, which will be necessary for manipulating routes and processing requests
     *
     * @param string $method
     * @param string $path
     * @param callable $callback
     * @return void
     */
    public function addRoute(string $method, string $path, callable $callback): void
    {
        $this->routes[] = new Route($method, $path, $callback);
    }

    /**
     * Used for route manipulation and targets the request according to the callback
     *
     * @param Request $request
     * @return void
     */
    public function handleRequest(Request $request): void
    {
        foreach ($this->routes as $route) {
            if ($this->match($route, $request)) {
                call_user_func($route->getCallback(), $this->params);
                return;
            }
        }

        // Se nenhuma rota for encontrada, responde com 404
        http_response_code(404);
    }

    /**
     * Find correct route to access
     *
     * @param Route $route
     * @param Request $request
     * @return bool
     */
    private function match(Route $route, Request $request): bool
    {
        // Verifica o método HTTP
        if ($route->getMethod() !== $request->getMethod()) {
            return false;
        }

        $pattern = $this->createPattern($route->getUri());
        $pattern = "#^" . $pattern . "$#";

        // Verifica se a rota acessada condiz com a rota encontrada no arquivo routes.php do módulo
        if (preg_match($pattern, $request->getUri(), $matches)) {
            array_shift($matches); // Remove o primeiro elemento que é o caminho completo

            $this->params = array_map('trim', $matches);
            return true;
        }

        return false;
    }

    /**
     * Create pattern to be used on preg_match() function
     *
     * @param string $uri
     * @return string
     */
    private function createPattern(string $uri): string
    {
        return preg_replace('/\{(\w+)\}/', '(\d+)', $uri);
    }
}