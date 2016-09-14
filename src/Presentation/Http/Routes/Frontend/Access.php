<?php

/**
 * Frontend Access Controllers
 */
Route::group(['namespace' => 'Auth'], function () {
    /**
     * These routes require the user to be logged in
     */
    Route::group(['middleware' => 'auth'], function () {
        Route::get('auth/logout', 'AuthController@getLogout');
    });

    /**
     * These reoutes require the user NOT be logged in
     */
    Route::group(['middleware' => 'guest'], function () {
        Route::get('auth/login/{provider}', 'AuthController@loginThirdParty')->name('auth.provider');
        Route::get('account/confirm/{token}', 'AuthController@confirmAccount')->name('account.confirm');
        Route::get('account/confirm/resend/{user_id}', 'AuthController@resendConfirmationEmail')->name('account.confirm.resend');

        Route::resource('auth', 'AuthController');
        Route::resource('password', 'PasswordController');
    });
});
