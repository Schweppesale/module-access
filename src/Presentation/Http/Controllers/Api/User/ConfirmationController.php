<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api\User;

use Illuminate\Http\Response;

/**
 * Class ConfirmationController
 * @package Schweppesale\Module\Access\Presentation\Http\Controllers\Api\User
 */
class ConfirmationController
{

    /**
     * @var Response
     */
    private $response;

    /**
     * ConfirmationController constructor.
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @param $token
     * @return mixed
     */
    public function confirmUserToken($token)
    {
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function resendConfirmationEmail($userId)
    {
    }
}