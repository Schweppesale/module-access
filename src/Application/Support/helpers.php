<?php

if (!function_exists('access')) {
    /**
     * Access (lol) the Access:: facade as a simple function
     */
    function access()
    {
        return app('Schweppesale\Module\Access\Application\Services\Access');
    }
}