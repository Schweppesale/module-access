<?php

use Illuminate\Routing\Router;

Route::group([
    'prefix' => 'access',
//    'middleware' => 'access.routeNeedsPermission:view-access-management'
], function (Router $router) {
    /**
     * User Management
     */
    $router->group(['namespace' => 'User'], function (Router $router) {
        $router->resource('users', 'UserController');

        $router->get('users/deactivated', 'UserController@deactivated')->name('admin.access.users.deactivated');
        $router->get('users/banned', 'UserController@banned')->name('admin.access.users.banned');
        $router->get('users/deleted', 'UserController@deleted')->name('admin.access.users.deleted');
        $router->get('account/confirm/resend/{user_id}', 'UserController@resendConfirmationEmail')->name('admin.account.confirm.resend');


//        $router->group(['prefix' => 'users/{id}', 'where' => ['id' => '[0-9]+']], function (Router $router) {
//            $router->get('delete', 'UserController@delete')->name('admin.access.user.delete-permanently');
//            $router->get('restore', 'UserController@restore')->name('admin.access.user.restore');
//            $router->get('activate', 'UserController@activate')->name('admin.access.user.activate');
//            $router->get('deactivate', 'UserController@deactivate')->name('admin.access.user.deactivate');
//
//            $router->get('ban', 'UserController@ban')->name('admin.access.user.ban');
//
////            get('mark/{status}', 'UserController@mark')->name('admin.access.user.mark')->where(['status' => '[0,1,2]']);
//            $router->get('password/change', 'UserController@changePassword')->name('admin.access.user.change-password');
//            $router->post('password/change', 'UserController@updatePassword')->name('admin.access.user.change-password');
//        });
    });

    $router->group(['namespace' => 'Organisation'], function (Router $router) {

        $router->resource('organisations', 'OrganisationController', ['only' => ['index', 'show', 'create', 'edit', 'store',
            'update']]);
    });

    /**
     * Role Management
     */
    $router->group(['namespace' => 'Role'], function (Router $router) {
        $router->resource('roles', 'RoleController', ['except' => ['show']]);
    });

    /**
     * Permission Management
     */
    $router->group(['prefix' => 'roles', 'namespace' => 'Permission'], function (Router $router) {
        $router->resource('permission-group', 'PermissionGroupController', ['except' => ['index', 'show']]);
        $router->resource('permissions', 'PermissionController', ['except' => ['show']]);

        $router->group(['prefix' => 'groups'], function (Router $router) {
            $router->post('update-sort', 'PermissionGroupController@updateSort')->name('admin.access.roles.groups.update-sort');
        });
    });
});
