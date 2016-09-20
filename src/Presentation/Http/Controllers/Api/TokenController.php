<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Schweppesale\Module\Access\Application\Services\Users\AuthenticationService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Token\LoginRequest;
use Schweppesale\Module\Access\Presentation\Services\Api\Response;
use Schweppesale\Module\Core\Http\Controller;
use Schweppesale\Module\Core\Http\Laravel\Request;

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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        return $this->response->format(
            $this->auth->destroyApiToken(
                $request->get('email'),
                $request->get('password'),
                $request->get('token')
            )
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $this->response->format(
            $this->auth->getApiToken($request->get('email'), $request->get('password'))
        );
    }

    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function store(LoginRequest $request)
    {
        return $this->response->format(
            $this->auth->generateApiToken($request->get('email'), $request->get('password'))
        );
    }
}
