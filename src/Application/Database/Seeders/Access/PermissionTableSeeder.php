<?php
namespace Schweppesale\Access\Application\Database\Seeders\Access;

use App\Http\Controllers\Backend\Project\Access\ProjectAccessController;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{

    /**
     * @var \Schweppesale\Access\Application\Services\Permissions\PermissionService
     */
    private $permissionService;

    /**
     * PermissionTableSeeder constructor.
     *
     * @param \Schweppesale\Access\Application\Services\Permissions\PermissionService $permissionService
     */
    public function __construct(\Schweppesale\Access\Application\Services\Permissions\PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function run()
    {

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if (env('DB_DRIVER') == 'mysql') {
            DB::table(config('access.permissions_table'))->truncate();
            DB::table(config('access.permission_role_table'))->truncate();
            DB::table(config('access.permission_user_table'))->truncate();
        } elseif (env('DB_DRIVER') == 'sqlite') {
            DB::statement("DELETE FROM " . config('access.permissions_table'));
            DB::statement("DELETE FROM " . config('access.permission_role_table'));
            DB::statement("DELETE FROM " . config('access.permission_user_table'));
        } else { //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('access.permissions_table') . " CASCADE");
            DB::statement("TRUNCATE TABLE " . config('access.permission_role_table') . " CASCADE");
            DB::statement("TRUNCATE TABLE " . config('access.permission_user_table') . " CASCADE");
        }

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

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
