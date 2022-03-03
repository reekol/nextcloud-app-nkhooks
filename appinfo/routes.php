<?php
/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\Nkhooks\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */
return [
    'routes' => [
        ['name' => 'page#index',        'url' => '/',             'verb' => 'GET' ],
        ['name' => 'page#hooks_post',   'url' => '/hooks_post',   'verb' => 'POST'],
        ['name' => 'page#hooks_put',    'url' => '/hooks_put',    'verb' => 'POST'],
        ['name' => 'page#hooks_delete', 'url' => '/hooks_delete', 'verb' => 'POST'],
        ['name' => 'page#hooks_export', 'url' => '/hooks_export', 'verb' => 'POST'],
        ['name' => 'page#hooks_import', 'url' => '/hooks_import', 'verb' => 'POST'],
        ['name' => 'nkhooksApi#api_get','url' => '/api_get/{key}','verb' => 'GET' ],
        ['name' => 'nkhooksApi#api_get_topic','url' => '/api_get/{key}/{topic}','verb' => 'GET' ],
    ]
];
