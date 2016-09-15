<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Frontend\Auth;

use Schweppesale\Module\Core\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Schweppesale\Module\Access\Application\Services\Users\AuthenticationService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Frontend\Access\LoginRequest;

/**
 * Class AuthController
 *
 * @package Schweppesale\Module\Access\Presentation\Http\Controllers\Frontend\Auth
 */
class AuthController extends Controller
{

    use ThrottlesLogins;

    /**
     * @var AuthenticationService
     */
    private $auth;

    /**
     * AuthController constructor.
     *
     * @param AuthenticationService $auth
     */
    public function __construct(AuthenticationService $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param $token
     * @return mixed
     * @throws \Schweppesale\Module\Core\Exceptions\GeneralException
     */
    public function confirmAccount($token)
    {
        //Don't know why the exception handler is not catching this
        try {
            $this->auth->confirmUser($token);
            return redirect('/auth/login')->withFlashSuccess("Your account has been successfully confirmed!");
        } catch (GeneralException $e) {
            return redirect('/auth/login')->withInput()->withFlashDanger($e->getMessage());
        }
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        return view('frontend.auth.login');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        $this->auth->logout();
        return redirect()->route('home');
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginRequest $request)
    {

        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        //Don't know why the exception handler is not catching this
        try {
            $this->auth->login($request->get('email'), $request->get('password'));
            $this->clearLoginAttempts($request);

            return redirect()->intended('/dashboard');
        } catch (GeneralException $e) {

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return redirect()->back()->withInput()->withFlashDanger($e->getMessage());
        }
    }

    /**
     * Helper methods to get laravel's ThrottleLogin class to work with this package
     */

    public function show()
    {
        return view('access::frontend.auth.login');
    }

    /**
     * @return string
     */
    public function loginUsername()
    {
        return 'email';
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function resendConfirmationEmail($user_id)
    {
        try {
            $this->auth->sendConfirmationEmail($user_id);
            return redirect()->route('home')->withFlashSuccess("A new confirmation e-mail has been sent to the address on file.");
        } catch (GeneralException $e) {
            return redirect()->back()->withInput()->withFlashDanger($e->getMessage());
        }
    }

    /**
     * Generates social login links based on what is enabled
     *
     * @return string
     */
    protected function getSocialLinks()
    {
        $socialite_enable = [];
        $socialite_links = '';

        if (getenv('GITHUB_CLIENT_ID') != '') {
            $socialite_enable[] = link_to_route('auth.provider', trans('labels.login_with', ['social_media' => 'Github']), 'github');
        }

        if (getenv('FACEBOOK_CLIENT_ID') != '') {
            $socialite_enable[] = link_to_route('auth.provider', trans('labels.login_with', ['social_media' => 'Facebook']), 'facebook');
        }

        if (getenv('TWITTER_CLIENT_ID') != '') {
            $socialite_enable[] = link_to_route('auth.provider', trans('labels.login_with', ['social_media' => 'Twitter']), 'twitter');
        }

        if (getenv('GOOGLE_CLIENT_ID') != '') {
            $socialite_enable[] = link_to_route('auth.provider', trans('labels.login_with', ['social_media' => 'Google']), 'google');
        }

        for ($i = 0; $i < count($socialite_enable); $i++) {
            $socialite_links .= ($socialite_links != '' ? '&nbsp;|&nbsp;' : '') . $socialite_enable[$i];
        }

        return $socialite_links;
    }
}
