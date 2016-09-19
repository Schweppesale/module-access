<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Schweppesale\Module\Access\Application\Services\Users\AuthenticationService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Token\LoginRequest;
use Schweppesale\Module\Access\Presentation\Services\Api\Response;
use Schweppesale\Module\Core\Exceptions\Exception;
use Schweppesale\Module\Core\Http\Controller;

/**
 * Class TokenController
 * @package Schweppesale\Module\Access\Presentation\Http\Controllers\Api
 */
class TokenController extends Controller
{

    /**
     * @var AuthenticationService
     */
    private $auth;

    /**
     * @var Response
     */
    private $response;

    /**
     * TokenController constructor.
     * @param Response $response
     * @param AuthenticationService $auth
     */
    public function __construct(Response $response, AuthenticationService $auth)
    {
        $this->auth = $auth;
        $this->response = $response;
    }

    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function store(LoginRequest $request)
    {
        return $this->response->format(
            $this->auth->generateToken($request->get('email'), $request->get('password'))
        );
    }
}
