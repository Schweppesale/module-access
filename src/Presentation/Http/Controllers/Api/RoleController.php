<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Schweppesale\Module\Access\Application\Services\Roles\RoleService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Role\DeleteRoleRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Role\EditRoleRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Role\StoreRoleRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Role\UpdateRoleRequest;
use Schweppesale\Module\Access\Presentation\Services\Api\Response;
use Schweppesale\Module\Core\Http\Controller;

/**
 * Class RoleController
 *
 * @package App\Http\Controllers\Access
 */
class RoleController extends Controller
{

    /**
     * @var Response
     */
    private $response;
    /**
     * @var RoleService
     */
    private $roleService;

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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, DeleteRoleRequest $request)
    {
        return $this->response->format($this->roleService->delete($id));
    }

    /**
     * @param $id
     * @param EditRoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id, EditRoleRequest $request)
    {
        return $this->response->format($this->roleService->editMeta($id));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->response->format($this->roleService->findAll());
    }

    /**
     * @param $permissionId
     * @return \Illuminate\Http\Response
     */
    public function indexByPermission($permissionId)
    {
        return $this->response->format($this->roleService->findByPermissionId($permissionId));
    }

    /**
     * @param $userId
     * @return \Illuminate\Http\Response
     */
    public function indexByUser($userId)
    {
        return $this->response->format($this->roleService->findByUserId($userId));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->response->format($this->roleService->getById($id));
    }

    /**
     * @param StoreRoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        return $this->response->format($this->roleService->create($request->all()));
    }

    /**
     * @param $id
     * @param UpdateRoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateRoleRequest $request)
    {
        return $this->response->format($this->roleService->update($id, $request->all()));
    }
}
