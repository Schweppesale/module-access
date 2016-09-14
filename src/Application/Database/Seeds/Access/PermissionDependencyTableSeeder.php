<?php
namespace Schweppesale\Module\Access\Application\Database\Seeders\Access;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class PermissionDependencyTableSeeder
 */
class PermissionDependencyTableSeeder extends Seeder
{

    /**
     * @var \Schweppesale\Module\Access\Application\Services\Permissions\PermissionService
     */
    private $projectService;

    /**
     * @var \Schweppesale\Module\Access\Application\Services\Permissions\PermissionGroupService
     */
    private $permissionGroupService;

    /**
     * PermissionGroupTableSeeder constructor.
     *
     * @param \Schweppesale\Module\Access\Application\Services\Permissions\PermissionService $permissionService
     */
    public function __construct(\Schweppesale\Module\Access\Application\Services\Permissions\PermissionService $projectService, \Schweppesale\Module\Access\Application\Services\Permissions\PermissionGroupService $permissionGroupService)
    {
        $this->projectService = $projectService;
        $this->permissionGroupService = $permissionGroupService;
    }

    /**
     *
     */
    public function run()
    {
//        if (env('DB_DRIVER') == 'mysql') {
//            DB::table('permission_dependencies')->truncate();
//        } elseif (env('DB_DRIVER') == 'sqlite') {
//            DB::statement("DELETE FROM " . 'permission_dependencies');
//        } else { //For PostgreSQL or anything else
//            DB::statement("TRUNCATE TABLE " . 'permission_dependencies' . " CASCADE");
//        }

        //View access management needs view backend
        DB::table('permission_dependencies')->insert([
            'permission_id' => 2,
            'dependency_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        //All of the access permissions need view access management and view backend
        for ($i = 3; $i <= 17; $i++) {
            DB::table('permission_dependencies')->insert([
                'permission_id' => $i,
                'dependency_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table('permission_dependencies')->insert([
                'permission_id' => $i,
                'dependency_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }


        //All of the access permissions need view access management and view backend
        for ($i = 19; $i <= 23; $i++) {
            DB::table('permission_dependencies')->insert([
                'permission_id' => $i,
                'dependency_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        /**
         * Project Permissions
         */

        $this->permissionGroupService->create('Projects', 1);
        $this->projectService->create(12731);
    }
}
