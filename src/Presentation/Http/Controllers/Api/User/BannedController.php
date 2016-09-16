<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api\User;

use Illuminate\Http\Response;
use Schweppesale\Module\Access\Application\Services\Users\UserService;

/**
 * Class BannedController
 * @package Schweppesale\Module\Access\Presentation\Http\Controllers\Api\User
 */
class BannedController
{

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var Response
     */
    private $response;

    /**
     * BannedController constructor.
     * @param Response $response
     * @param UserService $userService
     */
    public function __construct(Response $response, UserService $userService)
    {
        $this->response = $response;
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->response->setContent($this->userService->findBanned());
    }
}