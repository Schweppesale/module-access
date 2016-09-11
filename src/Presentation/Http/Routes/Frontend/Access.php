<?php

/**
 * Frontend Access Controllers
 */
Route::group(['namespace' => 'Auth'], function () {
    /**
     * These routes require the user to be logged in
     */
    Route::group(['middleware' => 'auth'], function () {
        get('auth/logout', 'AuthController@getLogout');
    });

    /**
     * These reoutes require the user NOT be logged in
     */
    Route::group(['middleware' => 'guest'], function () {
        get('auth/login/{provider}', 'AuthController@loginThirdParty')->name('auth.provider');
        get('account/confirm/{token}', 'AuthController@confirmAccount')->name('account.confirm');
        get('account/confirm/resend/{user_id}', 'AuthController@resendConfirmationEmail')->name('account.confirm.resend');

        Route::controller('auth', 'AuthController');
        Route::controller('password', 'PasswordController');
    });
});
