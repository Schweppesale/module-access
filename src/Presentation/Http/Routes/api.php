<?php
use Illuminate\Routing\Router;

Route::group([
    'prefix' => 'api',
    'namespace' => 'Schweppesale\Module\Access\Presentation\Http\Controllers\Api'
], function (Router $router) {

    /**
     * Authentication
     */
    $router->resource('token', 'TokenController', ['only' => ['store', 'destroy']]);

    /**
     * Users
     */
    $router->group(['prefix' => 'users', 'namespace' => 'User'], function (Router $router) {
        $router->resource('banned', 'BannedController', ['only' => 'index', 'store']);
        $router->resource('deactivated', 'DeactivatedController', ['only' => 'index', 'store']);
        $router->resource('confirmation', 'ConfirmationController');
    });
    $router->resource('users', 'UserController');

    /**
     * Permission Groups
     */
    $router->resource('permission-groups', 'PermissionGroupController', ['only' => ['index', 'update', 'store', 'destroy']]);

    /**
     * Permissions
     */
    $router->resource('permissions', 'PermissionController');

    /**
     * Organisations
     */
    $router->resource('organisations', 'OrganisationController');

    /**
     * Roles
     */
    $router->resource('roles', 'RoleController');

});