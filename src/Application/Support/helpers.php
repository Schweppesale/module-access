<?php

if (!function_exists('access')) {
    /**
     * Access (lol) the Access:: facade as a simple function
     */
    function access()
    {
        return app('Step\Access\Application\Services\Access');
    }
}