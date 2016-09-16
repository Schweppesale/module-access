<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Illuminate\Http\Response;
use Schweppesale\Module\Access\Application\Services\Users\AuthenticationService;
use Schweppesale\Module\Access\Application\Services\Users\UserService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\User\CreateUserRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\User\DeleteUserRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\User\PermanentlyDeleteUserRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\User\StoreUserRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\User\UpdateUserRequest;
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
     * @param CreateUserRequest $request
     * @return mixed
     */
    public function create(CreateUserRequest $request)
    {
        return $this->response->setContent($this->userService->createMeta());
    }

    /**
     * @param $id
     * @param PermanentlyDeleteUserRequest $request
     * @return mixed
     */
    public function delete($id, PermanentlyDeleteUserRequest $request)
    {
        $this->userService->delete($id, false);
    }

    /**
     * @param $id
     * @param DeleteUserRequest $request
     * @return mixed
     */
    public function destroy($id, DeleteUserRequest $request)
    {
        return $this->response->setContent($this->userService->delete($id));
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->response->setContent($this->userService->findAll());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->response->setContent($this->userService->getById($id));
    }

    /**
     * @param StoreUserRequest $request
     * @return mixed
     */
    public function store(StoreUserRequest $request)
    {
        return $this->response->setContent(
            $this->userService->create(
                $request->get('name'),
                $request->get('email'),
                $request->get('password'),
                $request->get('assignees_roles'),
                $this->extractInt(',', $request->get('permissions')),
                $request->get('confirmed'),
                $request->get('confirmation_email'),
                $request->get('status')
            )
        );
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

    /**
     * @param $id
     * @param UpdateUserRequest $request
     * @return mixed
     */
    public function update($id, UpdateUserRequest $request)
    {
        return $this->response->setContent(
            $this->userService->update(
                $id,
                $request->get('name'),
                $request->get('email'),
                $request->get('assignees_roles'),
                $this->extractInt(',', $request->get('permissions')),
                $request->get('confirmed'),
                $request->get('status')
            )
        );
    }
}
