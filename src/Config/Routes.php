<?php

$routes->group('admin', function ($routes) {




        $routes->resource('remolques', [
                'filter' => 'permission:remolques-permission',
                'controller' => 'remolquesController',
                'except' => 'show',
                'namespace' => 'julio101290\boilerplateremolques\Controllers',
            ]);
            $routes->post('remolques/save'
                        , 'RemolquesController::save'
                        , ['namespace' => 'julio101290\boilerplateremolques\Controllers']
                        );
            $routes->post('remolques/getRemolques'
                        , 'RemolquesController::getRemolques'
                        , ['namespace' => 'julio101290\boilerplateremolques\Controllers']
                        );
            $routes->post('remolques/getRemolquesAjax'
                        , 'RemolquesController::getRemolquesAjax'
                        , ['namespace' => 'julio101290\boilerplateremolques\Controllers']
                        );

});
