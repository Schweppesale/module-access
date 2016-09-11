<?php
namespace Step\Access\Application\Database\Seeders\Access;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionGroupTableSeeder extends Seeder
{

    private $permissionGroupService;

    public function __construct(\Step\Access\Application\Services\Permissions\PermissionGroupService $permissionGroupService)
    {
        $this->permissionGroupService = $permissionGroupService;
    }

    public function run()
    {

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if (env('DB_DRIVER') == 'mysql') {
            DB::table(config('access.permission_group_table'))->truncate();
        } elseif (env('DB_DRIVER') == 'sqlite') {
            DB::statement("DELETE FROM " . config('access.permission_group_table'));
        } else { //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('access.permission_group_table') . " CASCADE");
        }

        /**
         * Create the Access groups
         */
        $access = $this->permissionGroupService->create('Access', true, null, 1);
        $this->permissionGroupService->create('User', true, $access->getId(), 2);
        $this->permissionGroupService->create('Role', true, $access->getId(), 3);
        $this->permissionGroupService->create('Permission', true, $access->getId(), 4);

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
