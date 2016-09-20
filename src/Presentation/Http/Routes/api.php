<?php
use Illuminate\Routing\Router;

Route::group([
    'prefix' => 'api',
    'namespace' => 'Schweppesale\Module\Access\Presentation\Http\Controllers\Api'
], function (Router $router) {

    /**
     * Authentication
     */
    $router->resource('tokens', 'TokenController', ['only' => ['store', 'destroy']]);

    $router->group(['middleware' => 'auth:api'], function (Router $router) {

        /**
         * Permissions
         */
        $router->get('permissions/{permission}/dependencies', [
            'as' => 'dependencies.permission.index',
            'uses' => 'PermissionController@indexDependencies'
        ]);
        $router->get('users/{user}/permissions', [
            'as' => 'permissions.user.index',
            'uses' => 'PermissionController@indexByUser'
        ]);
        $router->get('roles/{role}/permissions', [
            'as' => 'permissions.role.index',
            'uses' => 'PermissionController@indexByRole'
        ]);
        $router->get('groups/{group}/permissions', [
            'as' => 'permissions.group.index',
            'uses' => 'PermissionController@indexByGroup'
        ]);
        $router->resource('permissions', 'PermissionController');

        /**
         * Roles
         */
        $router->get('users/{user}/roles', [
            'as' => 'roles.user.index',
            'uses' => 'RoleController@indexByUser'
        ]);
        $router->get('permissions/{permission}/roles', [
            'as' => 'roles.permission.index',
            'uses' => 'RoleController@indexByPermission'
        ]);
        $router->resource('roles', 'RoleController');

        /**
         * Users
         */
        $router->get('permissions/{permission}/users', [
            'as' => 'users.permission.index',
            'uses' => 'UserController@indexByPermission'
        ]);
        $router->resource('users', 'UserController');

        /**
         * Groups
         */
        $router->resource('groups', 'GroupController', ['only' => ['index', 'show', 'update', 'store', 'destroy']]);

        /**
         * Organisations
         */
        $router->resource('organisations', 'OrganisationController');

    });

});