<?php
/**
 * Api Routes
 */
Route::group(['namespace' => 'Schweppesale\Module\Access\Presentation\Http\Controllers\Api'], function () {

    Route::group(['prefix' => 'api'], function () {
        require(__DIR__ . "/Routes/Api/Profile.php");
        require(__DIR__ . "/Routes/Api/Access.php");
    });
});
