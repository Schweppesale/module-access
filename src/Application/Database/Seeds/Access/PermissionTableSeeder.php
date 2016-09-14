<?php
namespace Schweppesale\Module\Access\Application\Database\Seeders\Access;

use App\Http\Controllers\Backend\Project\Access\ProjectAccessController;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{

    /**
     * @var \Schweppesale\Module\Access\Application\Services\Permissions\PermissionService
     */
    private $permissionService;

    /**
     * PermissionTableSeeder constructor.
     *
     * @param \Schweppesale\Module\Access\Application\Services\Permissions\PermissionService $permissionService
     */
    public function __construct(\Schweppesale\Module\Access\Application\Services\Permissions\PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function run()
    {
//        if (env('DB_DRIVER') == 'mysql') {
//            DB::table('permissions')->truncate();
//            DB::table('permission_role')->truncate();
//            DB::table('user_permissions')->truncate();
//        } elseif (env('DB_DRIVER') == 'sqlite') {
//            DB::statement("DELETE FROM " . 'permissions');
//            DB::statement("DELETE FROM " . 'permission_role');
//            DB::statement("DELETE FROM " . 'user_permissions');
//        } else { //For PostgreSQL or anything else
//            DB::statement("TRUNCATE TABLE " . 'permissions' . " CASCADE");
//            DB::statement("TRUNCATE TABLE " . 'permission_role' . " CASCADE");
//            DB::statement("TRUNCATE TABLE " . 'user_permissions' . " CASCADE");
//        }

        //Don't need to assign any permissions to administrator because the all flag is set to true

        /**
         * Misc Access Permissions
         */
        $this->permissionService->create('view-access-management', 'View Access Management', 1, 2, null, true);

        /**
         * User
         */
        $this->permissionService->create('create-users', 'Create Users', 2, 5, null, true);
        $this->permissionService->create('edit-users', 'Edit Users', 2, 6, null, true);
        $this->permissionService->create('delete-users', 'Delete Users', 2, 7, null, true);
        $this->permissionService->create('change-user-password', 'Delete Users', 2, 8, null, true);
        $this->permissionService->create('deactivate-users', 'Deactivate Users', 2, 9, null, true);
        $this->permissionService->create('ban-users', 'Ban Users', 2, 10, null, true);
        $this->permissionService->create('reactivate-users', 'Re-Activate Users', 2, 11, null, true);
        $this->permissionService->create('unban-users', 'Un-Ban Users', 2, 12, null, true);
        $this->permissionService->create('undelete-users', 'Restore Users', 2, 13, null, true);
        $this->permissionService->create('permanently-delete-users', 'Permanently Delete Users', 2, 14, null, true);
        $this->permissionService->create('resend-user-confirmation-email', 'Resend Confirmation E-mail', 2, 15, null, true);


        /**
         * Role
         */
        $this->permissionService->create('create-roles', 'Create Roles', 3, 2, null, true);
        $this->permissionService->create('edit-roles', 'Edit Roles', 3, 3, null, true);
        $this->permissionService->create('delete-roles', 'Delete Roles', 3, 4, null, true);


        /**
         * Permission Group
         */
        $this->permissionService->create('edit-permission-groups', 'Edit Permission Groups', 4, 2, null, true);
        $this->permissionService->create('delete-permission-groups', 'Delete Permission Groups', 4, 3, null, true);
    }
}