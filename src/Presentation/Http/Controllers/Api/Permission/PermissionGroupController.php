<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api\Permission;

use App\Http\Controllers\Controller;
use Schweppesale\Module\Access\Application\Services\Permissions\PermissionGroupService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\CreatePermissionGroupRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\DeletePermissionGroupRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\EditPermissionGroupRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\SortPermissionGroupRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\StorePermissionGroupRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\UpdatePermissionGroupRequest;

/**
 * Class PermissionGroupController
 *
 * @package App\Http\Controllers\Access
 */
class PermissionGroupController extends Controller
{

    /**
     * @var PermissionGroupService
     */
    private $permissionGroupService;

    /**
     * PermissionGroupController constructor.
     *
     * @param PermissionGroupService $permissionGroupService
     */
    public function __construct(PermissionGroupService $permissionGroupService)
    {
        $this->permissionGroupService = $permissionGroupService;
    }

    /**
     * @param CreatePermissionGroupRequest $request
     * @return \Illuminate\View\View
     */
    public function create(CreatePermissionGroupRequest $request)
    {
        return view('access::backend.roles.permissions.groups.create');
    }

    /**
     * @param $id
     * @param DeletePermissionGroupRequest $request
     * @return mixed
     */
    public function destroy($id, DeletePermissionGroupRequest $request)
    {
        $this->permissionGroupService->delete($id);
        return redirect()->route('admin.access.roles.permissions.index')->withFlashSuccess(trans("alerts.permissions.groups.deleted"));
    }

    /**
     * @param $id
     * @param EditPermissionGroupRequest $request
     * @return mixed
     */
    public function edit($id, EditPermissionGroupRequest $request)
    {
        return view('access::backend.roles.permissions.groups.edit')
            ->withGroup($this->permissionGroupService->getById($id));
    }

    /**
     * @param StorePermissionGroupRequest $request
     * @return mixed
     */
    public function store(StorePermissionGroupRequest $request)
    {
        $this->permissionGroupService->create($request->get('name'));
        return redirect()->route('admin.access.roles.permissions.index')->withFlashSuccess(trans("alerts.permissions.groups.created"));
    }

    /**
     * @param $id
     * @param UpdatePermissionGroupRequest $request
     * @return mixed
     */
    public function update($id, UpdatePermissionGroupRequest $request)
    {
        $this->permissionGroupService->update($id, $request->get('name'));
        return redirect()->route('admin.access.roles.permissions.index')->withFlashSuccess(trans("alerts.permissions.groups.created"));
    }

    /**
     * @param SortPermissionGroupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSort(SortPermissionGroupRequest $request)
    {
        $this->permissionGroupService->updateSort($request->get('data'));
        return response()->json(['status' => 'OK']);
    }
}
