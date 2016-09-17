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
    $router->resource('users', 'UserController');
    $router->get('users/{user}/roles', ['as' => 'users.roles', 'uses' => 'UserController@roles']);
    $router->get('users/{user}/permissions', ['as' => 'users.permissions', 'uses' => 'UserController@permissions']);

    /**
     * Permission Groups
     */
    $router->resource('permission-groups', 'PermissionGroupController', ['only' => ['index', 'show', 'update', 'store', 'destroy']]);

    /**
     * Permissions
     */
    $router->resource('permissions', 'PermissionController');
    $router->get('paermissions/{user}/dependencies', ['as' => 'permissions.dependencies', 'uses' => 'PermissionController@dependencies']);

    /**
     * Organisations
     */
    $router->resource('organisations', 'OrganisationController');

    /**
     * Roles
     */
    $router->resource('roles', 'RoleController');

});