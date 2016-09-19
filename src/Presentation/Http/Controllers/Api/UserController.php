<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Schweppesale\Module\Access\Application\Services\Users\AuthenticationService;
use Schweppesale\Module\Access\Application\Services\Users\UserService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\User\CreateUserRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\User\DeleteUserRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\User\PermanentlyDeleteUserRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\User\StoreUserRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\User\UpdateUserRequest;
use Schweppesale\Module\Access\Presentation\Services\Api\Response;
use Schweppesale\Module\Core\Http\Controller;

/**
 * Class UserController
 * @package Schweppesale\Module\Access\Presentation\Http\Controllers\Api\User
 */
class UserController extends Controller
{

    /**
     * @var AuthenticationService
     */
    private $authenticationService;
    /**
     * @var Response|Response
     */
    private $response;
    /**
     * @var UserService
     */
    private $userService;

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
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function create(CreateUserRequest $request)
    {
        return $this->response->format($this->userService->createMeta());
    }

    /**
     * @param $id
     * @param PermanentlyDeleteUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function delete($id, PermanentlyDeleteUserRequest $request)
    {
        return $this->response->format($this->userService->delete($id, false));
    }

    /**
     * @param $id
     * @param DeleteUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, DeleteUserRequest $request)
    {
        return $this->response->format($this->userService->delete($id));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->response->format($this->userService->findAll());
    }

    /**
     * @param $permissionId
     * @return \Illuminate\Http\Response
     */
    public function indexByPermission($permissionId)
    {
        return $this->response->format($this->userService->findByPermissionId($permissionId));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->response->format($this->userService->getById($id));
    }

    /**
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        return $this->response->format(
            $this->userService->create(
                $request->get('name'),
                $request->get('email'),
                $request->get('password'),
                $request->get('assignees_roles'),
                explode(',', $request->get('permissions')),
                $request->get('confirmation_email'),
                $request->get('status')
            )
        );
    }

    /**
     * @param $id
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        return $this->response->format(
            $this->userService->update(
                $id,
                $request->get('name'),
                $request->get('email'),
                $request->get('assignees_roles'),
                explode(',', $request->get('permissions')),
                $request->get('status')
            )
        );
    }
}
