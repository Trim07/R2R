<?php

use App\Modules\Customers\Http\Controllers\CustomersController;


return function (\App\Core\Routes\Router $router) {

    $router->addRoute('GET', '/api/customers', function () {
        (new CustomersController)->index();
    });

    $router->addRoute('GET', '/api/customers/{id}', function (array $data) {
        (new CustomersController)->show($data);
    });

    $router->addRoute('POST', '/api/customers', function (array $data) {
        (new CustomersController)->create($data);
    });

    $router->addRoute('PUT', '/api/customers', function (array $data) {
        (new CustomersController)->update($data);
    });

    $router->addRoute('DELETE', '/api/customers/{id}', function (array $data) {
        (new CustomersController)->delete($data);
    });
};