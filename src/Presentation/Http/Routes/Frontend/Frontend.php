<?php

/**
 * These frontend controllers require the user to be logged in
 */
Route::group(['middleware' => 'auth'], function () {

    Route::get('dashboard', function () {
        return redirect(route('backend.dashboard'));
    })->name('frontend.dashboard');

});
