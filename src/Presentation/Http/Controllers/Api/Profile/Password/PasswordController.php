<?php

namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api\Profile\Password;

use App\Http\Controllers\Controller;
use Schweppesale\Module\Access\Application\Services\Users\ProfileService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Frontend\Access\ChangePasswordRequest;

/**
 * Class PasswordController
 *
 * @package Schweppesale\Module\Access\Presentation\Http\Controllers\Api\Profile
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
