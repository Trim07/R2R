<?php

return function (\App\Core\Routes\Router $router) {
    $router->addRoute('GET', '/customers', function () {
        echo json_encode(['data' => ["123"]]);
    });

    $router->addRoute('POST', '/customers', function () {
        return json_encode(['data' => []]);
    });

    $router->addRoute('GET', '/customers/{id}', function (int $id) {
        return json_encode(['data' => []]);
    });

    $router->addRoute('PUT', '/customers/{id}', function (int $id) {
        return json_encode(['data' => []]);
    });

    $router->addRoute('DELETE', '/customers/{id}', function (int $id) {
        return json_encode(['data' => []]);
    });
};