<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Response;
use Schweppesale\Module\Access\Application\Services\Users\AuthenticationService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Token\LoginRequest;
use Schweppesale\Module\Core\Exceptions\Exception;
use Schweppesale\Module\Core\Http\Controller;

/**
 * Class TokenController
 * @package Schweppesale\Module\Access\Presentation\Http\Controllers\Api
 */
class TokenController extends Controller
{

    use ThrottlesLogins;

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
     * @param $token
     */
    public function destroy($token)
    {
        $this->auth->logout();
    }

    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function store(LoginRequest $request)
    {

        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        try {

            $this->auth->login($request->get('email'), $request->get('password'));
            $this->clearLoginAttempts($request);
            return $this->response->setContent(['success' => true]);

        } catch (Exception $e) {

            $this->incrementLoginAttempts($request);

        }
    }
}
