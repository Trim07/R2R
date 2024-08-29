<?php

use App\Modules\Users\Http\Controllers\UsersController;


return function (\App\Core\Routes\Router $router) {

    $router->addRoute('GET', '/users', function () {
        (new UsersController)->index();
    });

    $router->addRoute('GET', '/users/{id}', function (array $data) {
        (new UsersController)->show($data);
    });

    $router->addRoute('POST', '/users', function (array $data) {
        (new UsersController)->create($data);
    });

    $router->addRoute('PUT', '/users', function (array $data) {
        (new UsersController)->update($data);
    });

    $router->addRoute('DELETE', '/users/{id}', function (array $data) {
        (new UsersController)->delete($data);
    });

    $router->addRoute('POST', '/users/login', function (array $data) {
        (new UsersController)->login($data);
    });

    $router->addRoute('POST', '/users/logout', function (array $data) {
        (new UsersController)->logout();
    });
};