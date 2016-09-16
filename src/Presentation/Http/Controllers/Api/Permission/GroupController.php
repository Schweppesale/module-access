<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api\Permission;

use Schweppesale\Module\Core\Http\Controller;
use Illuminate\Http\Response;
use Schweppesale\Module\Access\Application\Services\Permissions\PermissionGroupService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\DeletePermissionGroupRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\SortPermissionGroupRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\StorePermissionGroupRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\UpdatePermissionGroupRequest;

/**
 * Class GroupController
 * @package Schweppesale\Module\Access\Presentation\Http\Controllers\Api\Permission
 */
class GroupController extends Controller
{

    /**
     * @var PermissionGroupService
     */
    private $permissionGroupService;

    /**
     * @var Response
     */
    private $response;

    /**
     * GroupController constructor.
     * @param Response $response
     * @param PermissionGroupService $permissionGroupService
     */
    public function __construct(Response $response, PermissionGroupService $permissionGroupService)
    {
        $this->response = $response;
        $this->permissionGroupService = $permissionGroupService;
    }

    /**
     * @param $id
     * @param DeletePermissionGroupRequest $request
     * @return mixed
     */
    public function destroy($id, DeletePermissionGroupRequest $request)
    {
        return $this->response->setContent($this->permissionGroupService->delete($id));
    }

    /**
     * @param StorePermissionGroupRequest $request
     * @return mixed
     */
    public function store(StorePermissionGroupRequest $request)
    {
        return $this->response->setContent($this->permissionGroupService->create($request->get('name')));
    }

    /**
     * @param $id
     * @param UpdatePermissionGroupRequest $request
     * @return mixed
     */
    public function update($id, UpdatePermissionGroupRequest $request)
    {
        return $this->response->setContent($this->permissionGroupService->update($id, $request->get('name')));
    }

    /**
     * @param SortPermissionGroupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
//    public function updateSort(SortPermissionGroupRequest $request)
//    {
//        $this->permissionGroupService->updateSort($request->get('data'));
//    }
}
