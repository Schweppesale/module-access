<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Hateoas\HateoasBuilder;
use Hateoas\Serializer\JsonSerializerInterface;
use Illuminate\Http\Response;
use JMS\Serializer\SerializerInterface;
use LaravelDoctrine\ORM\Serializers\JsonSerializer;
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
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * UserController constructor.
     * @param Response $response
     * @param SerializerInterface $serializer
     * @param UserService $userService
     * @param AuthenticationService $authenticationService
     */
    public function __construct(Response $response, SerializerInterface $serializer, UserService $userService, AuthenticationService $authenticationService)
    {
        $this->response = $response;
        $this->serializer = $serializer;
        $this->userService = $userService;
        $this->authenticationService = $authenticationService;
    }

    /**
     * @param CreateUserRequest $request
     * @return mixed
     */
    public function create(CreateUserRequest $request)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->userService->createMeta(), 'json')
        );
    }

    /**
     * @param $id
     * @param PermanentlyDeleteUserRequest $request
     * @return mixed
     */
    public function delete($id, PermanentlyDeleteUserRequest $request)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->userService->delete($id, false), 'json')
        );
    }

    /**
     * @param $id
     * @param DeleteUserRequest $request
     * @return mixed
     */
    public function destroy($id, DeleteUserRequest $request)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->userService->delete($id), 'json')
        );
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->userService->findAll(), 'json')
        );
    }

    public function permissions($id)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->userService->getById($id)->getPermissions(), 'json')
        );
    }

    public function roles($id)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->userService->getById($id)->getRoles(), 'json')
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->userService->getById($id), 'json')
        );
    }

    /**
     * @param StoreUserRequest $request
     * @return mixed
     */
    public function store(StoreUserRequest $request)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize(
                $this->userService->create(
                    $request->get('name'),
                    $request->get('email'),
                    $request->get('password'),
                    $request->get('assignees_roles'),
                    $this->extractInt(',', $request->get('permissions')),
                    $request->get('confirmed'),
                    $request->get('confirmation_email'),
                    $request->get('status')
                ), 'json'
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
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize(
                $this->userService->update(
                    $id,
                    $request->get('name'),
                    $request->get('email'),
                    $request->get('assignees_roles'),
                    $this->extractInt(',', $request->get('permissions')),
                    $request->get('confirmed'),
                    $request->get('status')
                ), 'json'
            )
        );
    }
}
