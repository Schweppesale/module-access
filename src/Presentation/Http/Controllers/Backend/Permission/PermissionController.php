<?php namespace Schweppesale\Access\Presentation\Http\Controllers\Backend\Permission;

use Schweppesale\Access\Application\Services\Permissions\PermissionGroupService;
use Schweppesale\Access\Application\Services\Permissions\PermissionService;
use App\Http\Controllers\Controller;

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
