<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Schweppesale\Module\Access\Application\Services\Users\AuthenticationService;
use Schweppesale\Module\Access\Application\Services\Users\TokenService;
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
     * @var TokenService
     */
    private $tokenService;

    /**
     * @var Response
     */
    private $response;

    /**
     * TokenController constructor.
     * @param Response $response
     * @param TokenService $tokenService
     */
    public function __construct(Response $response, TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
        $this->response = $response;
    }

    /**
     * @param $tokenId
     * @return \Illuminate\Http\Response
     */
    public function destroy($token)
    {
        return $this->response->format(
            $this->tokenService->destroyToken($token)
        );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $this->response->format(
            $this->tokenService->getToken($request->get('email'), $request->get('password'))
        );
    }

    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function store(LoginRequest $request)
    {
        return $this->response->format(
            $this->tokenService->generateToken($request->get('email'), $request->get('password'))
        );
    }
}
