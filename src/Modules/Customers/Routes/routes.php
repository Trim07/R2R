<?php

use App\Modules\Customers\Http\Controllers\CustomersController;


return function (\App\Core\Routes\Router $router) {

    $router->addRoute('GET', '/customers', function () {
        (new CustomersController)->index();
    });

    $router->addRoute('GET', '/customers/{id}', function (array $data) {
        (new CustomersController)->show($data);
    });

    $router->addRoute('POST', '/customers', function (array $data) {
        (new CustomersController)->create($data);
    });

    $router->addRoute('PUT', '/customers', function (array $data) {
        (new CustomersController)->update($data);
    });

    $router->addRoute('DELETE', '/customers/{id}', function (array $data) {
        (new CustomersController)->delete($data);
    });
};