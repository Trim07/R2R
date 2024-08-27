<?php

namespace App\Core\Routes;

/**
 * Class responsible for managing routes and directing them to their respective destinations
 */
class Router implements RouterInterface
{
    private array $routes = [];

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
            if ($route->getMethod() === $request->getMethod() && $route->getPath() === $request->getPath()) {
                call_user_func($route->getCallback());
                return;
            }
        }

        // Se nenhuma rota for encontrada, responde com 404
        http_response_code(404);
        echo '404 Not Found';
    }
}