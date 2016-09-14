<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Backend\Role;

use App\Http\Controllers\Controller;
use Schweppesale\Module\Access\Application\Services\Roles\RoleService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Role\CreateRoleRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Role\DeleteRoleRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Role\EditRoleRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Role\StoreRoleRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Role\UpdateRoleRequest;

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
     * RoleController constructor.
     *
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * @param CreateRoleRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(CreateRoleRequest $request)
    {
        return view('access::backend.roles.create', $this->roleService->createMeta());
    }

    /**
     * @param $id
     * @param DeleteRoleRequest $request
     * @return mixed
     */
    public function destroy($id, DeleteRoleRequest $request)
    {
        $this->roleService->delete($id);
        return redirect()->route('admin.access.roles.index')->withFlashSuccess(trans("alerts.roles.deleted"));
    }

    /**
     * @param $id
     * @param PermissionGroupRepositoryContract $group
     * @param EditRoleRequest $request
     * @return mixed
     */
    public function edit($id, EditRoleRequest $request)
    {
        return view('access::backend.roles.edit', $this->roleService->editMeta($id));
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return view('access::backend.roles.index', ['roles' => $this->roleService->fetchAll()]);
    }

    /**
     * @param StoreRoleRequest $request
     * @return mixed
     */
    public function store(StoreRoleRequest $request)
    {
        $this->roleService->create($request->all());
        return redirect()->route('admin.access.roles.index')->withFlashSuccess(trans("alerts.roles.created"));
    }

    /**
     * @param $id
     * @param UpdateRoleRequest $request
     * @return mixed
     */
    public function update($id, UpdateRoleRequest $request)
    {
        $this->roleService->update($id, $request->all());
        return redirect()->route('admin.access.roles.index')->withFlashSuccess(trans("alerts.roles.updated"));
    }
}
