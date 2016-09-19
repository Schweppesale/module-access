<?php
namespace Schweppesale\Module\Access\Application\Database\Seeds\Access;

use Illuminate\Database\Seeder;
use Schweppesale\Module\Access\Application\Services\Permissions\PermissionService;

class PermissionTableSeeder extends Seeder
{

    /**
     * @var PermissionService
     */
    private $permissionService;

    /**
     * PermissionTableSeeder constructor.
     *
     * @param PermissionService $permissionService
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function run()
    {

        /**
         * Misc Access Permissions
         */
        $viewId = $this->permissionService->create('view-access-management', 'View Access Management', 1, 2, null, true)->getId();

        /**
         * Users
         */
        $this->permissionService->create('create-users', 'Create Users', 2, 5, [$viewId], true);
        $this->permissionService->create('edit-users', 'Edit Users', 2, 6, [$viewId], true);
        $this->permissionService->create('delete-users', 'Delete Users', 2, 7, [$viewId], true);
        $this->permissionService->create('change-user-password', 'Delete Users', 2, 8, [$viewId], true);
        $this->permissionService->create('deactivate-users', 'Deactivate Users', 2, 9, [$viewId], true);
        $this->permissionService->create('ban-users', 'Ban Users', 2, 10, [$viewId], true);
        $this->permissionService->create('reactivate-users', 'Re-Activate Users', 2, 11, [$viewId], true);
        $this->permissionService->create('unban-users', 'Un-Ban Users', 2, 12, [$viewId], true);
        $this->permissionService->create('undelete-users', 'Restore Users', 2, 13, [$viewId], true);
        $this->permissionService->create('permanently-delete-users', 'Permanently Delete Users', 2, 14, [$viewId], true);
        $this->permissionService->create('resend-user-confirmation-email', 'Resend Confirmation E-mail', 2, 15, [$viewId], true);


        /**
         * Roles
         */
        $this->permissionService->create('create-roles', 'Create Roles', 3, 2, [$viewId], true);
        $this->permissionService->create('edit-roles', 'Edit Roles', 3, 3, [$viewId], true);
        $this->permissionService->create('delete-roles', 'Delete Roles', 3, 4, [$viewId], true);


        /**
         * Permission Groups
         */
        $this->permissionService->create('edit-groups', 'Edit Permission Groups', 4, 2, [$viewId], true);
        $this->permissionService->create('delete-groups', 'Delete Permission Groups', 4, 3, [$viewId], true);
    }
}
