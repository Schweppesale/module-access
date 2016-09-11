<?php namespace Step\Access\Presentation\Http\Controllers\Frontend\Auth;

use Step\Access\Application\Services\Users\AuthenticationService;
use Step\Access\Presentation\Entities\User;
use Step\Access\Presentation\Http\Requests\Frontend\Access\ChangePasswordRequest;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

/**
 * Class PasswordController
 *
 * @package App\Http\Controllers\Auth
 */
class PasswordController extends Controller
{

    /**
     * @var AuthenticationService
     */
    private $authService;

    /**
     * PasswordController constructor.
     *
     * @param AuthenticationService $authService
     */
    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @return \Illuminate\View\View
     */
//    public function getChangePassword()
//    {
//        return view('access::frontend.auth.change-password');
//    }

    /**
     * @return \Illuminate\View\View
     */
    public function getEmail()
    {
        return view('access::frontend.auth.password');
    }

    /**
     * @param null $token
     * @return mixed
     */
//    public function getReset($token = null)
//    {
//        if (is_null($token)) {
//            throw new NotFoundHttpException;
//        }
//        return view('access::frontend.auth.reset')->withToken($token);
//    }

    /**
     * @param ChangePasswordRequest $request
     * @return mixed
     */
//    public function postChangePassword(ChangePasswordRequest $request)
//    {
//        $this->authService->resetPassword($request->get('password'));
//        return redirect()->route('frontend.dashboard')->withFlashSuccess(trans("strings.password_successfully_changed"));
//    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     * @throws GeneralException
     */
    public function postEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
        $response = $this->authService->sendPasswordResetEmail($request->get('email'));
        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('status', trans($response));

            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }
}
