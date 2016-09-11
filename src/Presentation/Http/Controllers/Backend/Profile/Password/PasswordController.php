<?php

namespace Schweppesale\Access\Presentation\Http\Controllers\Backend\Profile\Password;

use Schweppesale\Access\Application\Services\Users\ProfileService;
use Schweppesale\Access\Presentation\Http\Requests\Frontend\Access\ChangePasswordRequest;
use App\Http\Controllers\Controller;

/**
 * Class PasswordController
 *
 * @package Schweppesale\Access\Presentation\Http\Controllers\Backend\Profile
 */
class PasswordController extends Controller
{

    /**
     * @var ProfileService
     */
    private $profileService;

    /**
     * PasswordController constructor.
     *
     * @param ProfileService $profileService
     */
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('access::backend.profile.password.edit');
    }

    /**
     * @param ChangePasswordRequest $request
     * @return mixed
     */
    public function update(ChangePasswordRequest $request)
    {
        $this->profileService->changePassword($request->get('password'));
        return redirect()->route('admin.profile.edit')->withFlashSuccess(trans("strings.password_successfully_changed"));
    }
}
