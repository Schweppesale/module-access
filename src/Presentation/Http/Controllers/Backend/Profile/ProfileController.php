<?php

namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Backend\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Schweppesale\Module\Access\Application\Services\Users\AuthenticationService;
use Schweppesale\Module\Access\Application\Services\Users\UserService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Frontend\User\UpdateProfileRequest;

/**
 * Class ProfileController
 *
 * @package Schweppesale\Module\Access\Presentation\Http\Controllers\Backend\Profile
 */
class ProfileController extends Controller
{

    /**
     * @var AuthenticationService|Guard
     */
    private $auth;

    /**
     * @var UserService
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
        return view('access::backend.profile.edit', ['user' => $user]);
    }

    /**
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = $this->auth->getUser();
        if (!$user instanceof \Schweppesale\Module\Access\Domain\Entities\User) {
            throw new \UnexpectedValueException('Invalid User Entity');
        }

        $this->userService->update($user->getId(), $request);
        return redirect(route('admin.profile.edit'))->withFlashSuccess("Your profile has been successfully updated.");
    }
}