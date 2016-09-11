<?php

namespace Schweppesale\Access\Presentation\Http\Controllers\Backend\Profile;

use Schweppesale\Access\Application\Services\Users\AuthenticationService;
use Schweppesale\Access\Application\Services\Users\UserService;
use Schweppesale\Access\Presentation\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

/**
 * Class ProfileController
 *
 * @package Schweppesale\Access\Presentation\Http\Controllers\Backend\Profile
 */
class ProfileController extends Controller
{

    /**
     * @var AuthenticationService|Guard
     */
    private $auth;

    /**
     * @var UserContract
     */
    private $userService;

    /**
     * ProfileController constructor.
     *
     * @param UserService $userService
     * @param Guard $auth
     */
    public function __construct(UserService $userService, AuthenticationService $auth)
    {
        $this->auth = $auth;
        $this->userService = $userService;
    }

    /**
     * @return $this
     */
    public function edit()
    {
        $user = $this->auth->getUser();
        return view('access::backend.profile.edit')->with('user', $user);
    }

    /**
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = $this->auth->getUser();
        if (!$user instanceof \Schweppesale\Access\Presentation\Entities\User) {
            throw new \UnexpectedValueException('Invalid User Entity');
        }
        dd($request->all());
        $this->userService->update($user->getId(), $request);
        return redirect(route('admin.profile.edit'))->withFlashSuccess("Your profile has been successfully updated.");
    }
}