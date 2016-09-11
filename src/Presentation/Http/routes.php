<?php
//
///**
// * Switch between the included languages
// */
////require(__DIR__ . "/Routes/Global/Lang.php");
//
///**
// * Frontend Routes
// * Namespaces indicate folder structure
// */
Route::group(['namespace' => 'Step\Access\Presentation\Http\Controllers\Frontend'], function () {
    require(__DIR__ . "/Routes/Frontend/Frontend.php");
    require(__DIR__ . "/Routes/Frontend/Access.php");
});
//
///**
// * Backend Routes
// * Namespaces indicate folder structure
// */
Route::group(['namespace' => 'Step\Access\Presentation\Http\Controllers\Backend'], function () {

    Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {

        /**
         * These routes need view-backend permission (good if you want to allow more than one group in the backend, then limit the backend features by different roles or permissions)
         *
         * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
         */
        require(__DIR__ . "/Routes/Backend/Profile.php");
        require(__DIR__ . "/Routes/Backend/Access.php");
    });
});
