<?php
namespace Schweppesale\Module\Access\Application\Database\Seeders\Access;

use Illuminate\Database\Seeder;

class PermissionGroupTableSeeder extends Seeder
{

    private $permissionGroupService;

    public function __construct(\Schweppesale\Module\Access\Application\Services\Permissions\PermissionGroupService $permissionGroupService)
    {
        $this->permissionGroupService = $permissionGroupService;
    }

    public function run()
    {
//        if (env('DB_DRIVER') == 'mysql') {
//            DB::table('permission_groups')->truncate();
//        } elseif (env('DB_DRIVER') == 'sqlite') {
//            DB::statement("DELETE FROM " . 'permission_groups');
//        } else { //For PostgreSQL or anything else
//            DB::statement("TRUNCATE TABLE " . 'permission_groups' . " CASCADE");
//        }

        /**
         * Create the Access groups
         */
        $access = $this->permissionGroupService->create('Access', true, null, 1);
        $this->permissionGroupService->create('User', true, $access->getId(), 2);
        $this->permissionGroupService->create('Role', true, $access->getId(), 3);
        $this->permissionGroupService->create('Permission', true, $access->getId(), 4);
    }
}
