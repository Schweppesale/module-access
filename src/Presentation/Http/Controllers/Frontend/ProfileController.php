<?php namespace Schweppesale\Access\Presentation\Http\Controllers\Frontend;

use Schweppesale\Access\Presentation\Http\Requests\Frontend\User\UpdateProfileRequest;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;

/**
 * Class ProfileController
 *
 * @package App\Http\Controllers\Frontend
 */
class ProfileController extends Controller
{

    /**
     * @return mixed
     */
    public function edit()
    {
        return view('access::frontend.user.profile.edit')
            ->withUser(auth()->user());
    }

    /**
     * @param UserContract $user
     * @param UpdateProfileRequest $request
     * @return mixed
     */
    public function update(UserContract $user, UpdateProfileRequest $request)
    {
        $user->updateProfile($request->all());
        return redirect()->route('frontend.dashboard')->withFlashSuccess(trans("strings.profile_successfully_updated"));
    }
}
