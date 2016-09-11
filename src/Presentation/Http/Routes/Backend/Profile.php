<?php

Route::group(['namespace' => 'Profile'], function ($router) {

    Route::get('profile', ['as' => 'admin.profile.edit', 'uses' => 'ProfileController@edit']);
    Route::patch('profile', ['as' => 'admin.profile.update', 'uses' => 'ProfileController@update']);

    Route::group(['namespace' => 'Password'], function ($router) {

        Route::get('profile/password', ['as' => 'admin.profile.password.edit', 'uses' => 'PasswordController@edit']);
        Route::patch('profile/password', ['as' => 'admin.profile.password.update',
                                          'uses' => 'PasswordController@update']);
    });

});
