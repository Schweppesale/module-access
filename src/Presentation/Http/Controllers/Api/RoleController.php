<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Hateoas\HateoasBuilder;
use Illuminate\Http\Response;
use JMS\Serializer\SerializerInterface;
use Schweppesale\Module\Access\Application\Services\Roles\RoleService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Role\DeleteRoleRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Role\EditRoleRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Role\StoreRoleRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Role\UpdateRoleRequest;
use Schweppesale\Module\Core\Http\Controller;

/**
 * Class RoleController
 *
 * @package App\Http\Controllers\Access
 */
class RoleController extends Controller
{

    /**
     * @var RoleService
     */
    private $roleService;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * RoleController constructor.
     * @param Response $response
     * @param SerializerInterface $serializer
     * @param RoleService $roleService
     */
    public function __construct(Response $response, SerializerInterface $serializer, RoleService $roleService)
    {
        $this->response = $response;
        $this->serializer = $serializer;
        $this->roleService = $roleService;
    }

    /**
     * @param $id
     * @param DeleteRoleRequest $request
     * @return mixed
     */
    public function destroy($id, DeleteRoleRequest $request)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->roleService->delete($id), 'json')
        );
    }

    /**
     * @param $id
     * @param EditRoleRequest $request
     * @return mixed
     * @internal param PermissionGroupRepositoryContract $group
     */
    public function edit($id, EditRoleRequest $request)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer>serialize($this->roleService->editMeta($id), 'json')
        );
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->roleService->findAll(), 'json')
        );
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->roleService->getById($id), 'json')
        );
    }

    /**
     * @param StoreRoleRequest $request
     * @return mixed
     */
    public function store(StoreRoleRequest $request)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->roleService->create($request->all()), 'json')
        );
    }

    /**
     * @param $id
     * @param UpdateRoleRequest $request
     * @return mixed
     */
    public function update($id, UpdateRoleRequest $request)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->roleService->update($id, $request->all()), 'json')
        );
    }
}
