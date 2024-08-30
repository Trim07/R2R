<?php

use App\Modules\Users\Http\Controllers\UsersController;


return function (\App\Core\Routes\Router $router) {

    $router->addRoute('GET', 'api/users', function () {
        (new UsersController)->index();
    });

    $router->addRoute('GET', 'api/users/{id}', function (array $data) {
        (new UsersController)->show($data);
    });

    $router->addRoute('POST', 'api/users', function (array $data) {
        (new UsersController)->create($data);
    });

    $router->addRoute('PUT', 'api/users', function (array $data) {
        (new UsersController)->update($data);
    });

    $router->addRoute('DELETE', 'api/users/{id}', function (array $data) {
        (new UsersController)->delete($data);
    });

    $router->addRoute('POST', 'api/users/login', function (array $data) {
        (new UsersController)->login($data);
    });

    $router->addRoute('POST', 'api/users/logout', function (array $data) {
        (new UsersController)->logout();
    });
};