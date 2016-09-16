<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Schweppesale\Module\Core\Http\Controller;
use Illuminate\Http\Response;
use Schweppesale\Module\Access\Application\Services\Roles\RoleService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Role\DeleteRoleRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Role\EditRoleRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Role\StoreRoleRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Role\UpdateRoleRequest;

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
     * RoleController constructor.
     * @param Response $response
     * @param RoleService $roleService
     */
    public function __construct(Response $response, RoleService $roleService)
    {
        $this->response = $response;
        $this->roleService = $roleService;
    }

    /**
     * @param $id
     * @param DeleteRoleRequest $request
     * @return mixed
     */
    public function destroy($id, DeleteRoleRequest $request)
    {
        return $this->response->setContent($this->roleService->delete($id));
    }

    /**
     * @param $id
     * @param EditRoleRequest $request
     * @return mixed
     * @internal param PermissionGroupRepositoryContract $group
     */
    public function edit($id, EditRoleRequest $request)
    {
        return $this->response->setContent($this->roleService->editMeta($id));
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->response->setContent($this->roleService->findAll());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->response->setContent($this->roleService->getById($id));
    }

    /**
     * @param StoreRoleRequest $request
     * @return mixed
     */
    public function store(StoreRoleRequest $request)
    {
        return $this->response->setContent($this->roleService->create($request->all()));
    }

    /**
     * @param $id
     * @param UpdateRoleRequest $request
     * @return mixed
     */
    public function update($id, UpdateRoleRequest $request)
    {
        return $this->response->setContent($this->roleService->update($id, $request->all()));
    }
}
