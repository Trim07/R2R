<?php

use App\Modules\Customers\Http\Controllers\CustomersController;


return function (\App\Core\Routes\Router $router) {

    $router->addRoute('GET', '/customers/list', function () {
        (new CustomersController)->index();
    });

    $router->addRoute('POST', '/customers', function () {
        return json_encode(['data' => []]);
    });

    $router->addRoute('GET', '/customers/{id}', function ($id) {
        $request = new \App\Core\Routes\Request();
         var_dump($id);
//        var_dump($request->all());
//        $id = $request->getQueryParam('id');
//         (new CustomersController)->show($id);
    });

    $router->addRoute('PUT', '/customers/{id}', function (int $id) {
        return json_encode(['data' => []]);
    });

    $router->addRoute('DELETE', '/customers/{id}', function (int $id) {
        return json_encode(['data' => []]);
    });
};