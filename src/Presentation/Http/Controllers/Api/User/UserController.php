<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Schweppesale\Module\Access\Application\Services\Users\AuthenticationService;
use Schweppesale\Module\Access\Application\Services\Users\ConfirmationService;
use Schweppesale\Module\Access\Application\Services\Users\UserService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User\ChangeUserPasswordRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User\CreateUserRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User\DeleteUserRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User\EditUserRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User\MarkUserRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User\PermanentlyDeleteUserRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User\ResendConfirmationEmailRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User\RestoreUserRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User\StoreUserRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User\UpdateUserPasswordRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\User\UpdateUserRequest;

//use App\Repositories\Backend\Permission\Group\PermissionGroupRepositoryContract;
//use App\Repositories\Frontend\Auth\AuthenticationContract;

/**
 * Class UserController
 */
class UserController extends Controller
{

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var Response
     */
    private $response;

    /**
     * UserController constructor.
     * @param Response $response
     * @param UserService $userService
     * @param AuthenticationService $authenticationService
     */
    public function __construct(Response $response, UserService $userService, AuthenticationService $authenticationService)
    {
        $this->response = $response;
        $this->userService = $userService;
        $this->authenticationService = $authenticationService;
    }

    /**
     * @return mixed
     */
    public function banned()
    {
        return view('access::backend.banned', ['users' => $this->userService->findBanned()]);
    }

    /**
     * @param $id
     * @param ChangeUserPasswordRequest $request
     * @return mixed
     */
    public function changePassword($id, ChangeUserPasswordRequest $request)
    {
        return view('access::backend.change-password', ['user' => $this->userService->getById($id)]);
    }

    /**
     * @param CreateUserRequest $request
     * @return mixed
     */
    public function create(CreateUserRequest $request)
    {
        return view('access::backend.create', $this->userService->createMeta());
    }

    /**
     * @return mixed
     */
    public function deactivated()
    {
        return view('access::backend.deactivated', ['users' => $this->userService->findDeactivated()]);
    }

    /**
     * @param $id
     * @param PermanentlyDeleteUserRequest $request
     * @return mixed
     */
    public function delete($id, PermanentlyDeleteUserRequest $request)
    {
        $this->userService->delete($id, false);
        return redirect()->back()->withFlashSuccess(trans("alerts.users.deleted_permanently"));
    }

    /**
     * @return mixed
     */
    public function deleted()
    {
        return view('access::backend.deleted', ['users' => $this->userService->findDeleted()]);
    }

    /**
     * @param $id
     * @param DeleteUserRequest $request
     * @return mixed
     */
    public function destroy($id, DeleteUserRequest $request)
    {
        $this->userService->delete($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.users.deleted"));
    }

    /**
     * @param $id
     * @param EditUserRequest $request
     * @return mixed
     */
    public function edit($id, EditUserRequest $request)
    {
        return view('access::backend.edit', $this->userService->editMeta($id));
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->response->setContent($this->userService->fetchAll());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function activate($id)
    {
        $this->userService->enable($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.users.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deactivate($id)
    {
        $this->userService->deactive($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.users.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function ban($id)
    {
        $this->userService->ban($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.users.updated"));
    }

    /**
     * @param $id
     * @param $status
     * @param MarkUserRequest $request
     * @return mixed
     */
    public function mark($id, $status, MarkUserRequest $request)
    {
        $this->userService->mark($id, $status);
        return redirect()->back()->withFlashSuccess(trans("alerts.users.updated"));
    }

    /**
     * @param $user_id
     * @param ResendConfirmationEmailRequest $request
     * @return mixed
     */
    public function resendConfirmationEmail($user_id, ResendConfirmationEmailRequest $request)
    {
        $this->authenticationService->sendConfirmationEmail($user_id);
        return redirect()->back()->withFlashSuccess(trans("alerts.users.confirmation_email"));
    }

    /**
     * @param $id
     * @param RestoreUserRequest $request
     * @return mixed
     */
    public function restore($id, RestoreUserRequest $request)
    {
        $this->userService->enable($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.users.restored"));
    }

    /**
     * @param StoreUserRequest $request
     * @return mixed
     */
    public function store(StoreUserRequest $request)
    {
        $this->userService->create(
            $request->get('name'),
            $request->get('email'),
            $request->get('password'),
            $request->get('assignees_roles'),
            $this->extractInt(',', $request->get('permissions')),
            $request->get('confirmed'),
            $request->get('confirmation_email'),
            $request->get('status')
        );
        return redirect()->route('admin.access.users.index')->withFlashSuccess(trans("alerts.users.created"));
    }

    /**
     * @param $id
     * @param UpdateUserRequest $request
     * @return mixed
     */
    public function update($id, UpdateUserRequest $request)
    {
        $this->userService->update(
            $id,
            $request->get('name'),
            $request->get('email'),
            $request->get('assignees_roles'),
            $this->extractInt(',', $request->get('permissions')),
            $request->get('confirmed'),
            $request->get('status')
        );
        return redirect()->route('admin.access.users.index')->withFlashSuccess(trans("alerts.users.updated"));
    }

    /**
     * @param $id
     * @param UpdateUserPasswordRequest $request
     * @return mixed
     */
    public function updatePassword($id, UpdateUserPasswordRequest $request)
    {
        $password = $request->get('password');
        $confirmation = $request->get('password_confirmation');

        $this->userService->changePassword($id, $password, $confirmation);
        return redirect()->route('admin.access.users.index')->withFlashSuccess(trans("alerts.users.updated_password"));
    }

    /**
     * @param $deliminator
     * @param $string
     * @return array
     */
    private function extractInt($deliminator, $string)
    {
        $results = [];
        $values = explode($deliminator, $string);
        foreach ($values as $value) {
            if (is_numeric($value)) {
                $results[] = $value;
            }
        }
        return $results;
    }
}
