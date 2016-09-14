<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Backend\Permission;

use App\Http\Controllers\Controller;
use Schweppesale\Module\Access\Application\Services\Permissions\PermissionGroupService;
use Schweppesale\Module\Access\Application\Services\Permissions\PermissionService;

/**
 * Class PermissionController
 *
 * @package App\Http\Controllers\Access
 */
class PermissionController extends Controller
{

    /**
     * @var PermissionService
     */
    private $permissionService;

    /**
     * @var PermissionGroupService
     */
    private $permissionGroupService;

    /**
     * PermissionController constructor.
     *
     * @param PermissionService $permissionService
     * @param PermissionGroupService $permissionGroupService
     */
    public function __construct(PermissionService $permissionService, PermissionGroupService $permissionGroupService)
    {
        $this->permissionService = $permissionService;
        $this->permissionGroupService = $permissionGroupService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return view('access::backend.roles.permissions.index',
            [
                'permissions' => $this->permissionService->fetchAll(),
                'groups' => $this->permissionGroupService->fetchAllParents()
            ]
        );
    }
}
