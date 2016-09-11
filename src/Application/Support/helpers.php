<?php

if (!function_exists('access')) {
    /**
     * Access (lol) the Access:: facade as a simple function
     */
    function access()
    {
        return app('Schweppesale\Access\Application\Services\Access');
    }
}