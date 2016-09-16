<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api\User;

use Illuminate\Http\Response;
use Schweppesale\Module\Access\Application\Services\Users\UserService;

/**
 * Class DeactivatedController
 * @package Schweppesale\Module\Access\Presentation\Http\Controllers\Api\User
 */
class DeactivatedController
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
     * DeactivatedController constructor.
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
        return $this->response->setContent($this->userService->findDeactivated());
    }
}